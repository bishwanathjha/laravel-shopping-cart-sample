<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Library\Api\Error;
use App\Library\Api\Response;
use Illuminate\Support\Facades\Hash;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;

/**
 * Class UserController
 * @package App\Http\Controllers\Api
 */
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $User = \Auth::guard('api')->user();
        if($User->role_type != User::ROLE_ADMIN) {
            $userData = User::where('id', $User->id)->paginate(10)->toArray();
        } else {
            $userData = User::paginate(10)->toArray();
        }
        $Response = new Response('GET', 'users', 200);

        $data = [];
        if(!empty($userData['data'])) {
            $data = $this->FilterData($userData['data']);
            $Response->SetPaginated($userData['total'], 10, $userData['from'] -1 );
        }

        return $Response->Success($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $message = $status = '';
        $userName = $request->get('name');
        $email = $request->get('email');
        $password = $request->get('password');
        $roleType = $request->get('role_type');
        $phone = $request->get('phone');
        $address = $request->get('address');

        // Anonymous user can be created with customer role type only
        $User = \Auth::guard('api')->user();
        if(!$User instanceof User || $User->role_type != User::ROLE_ADMIN)
            $roleType = 2;

        /**
         * @todo Improve error handling field wise like invalid or required
         */
        if(empty($userName) || empty($password) || empty($roleType) || empty($email)
        || filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            $status = 400;
            $message = 'Mandatory fields are missing like (name, email, password, role_type)';
        }

        $User = User::where('email', strtolower(trim($email)))->first();
        if($User instanceof  User) {
            $status = 400;
            $message = 'Email already taken';
        }

        if(empty($status)) {
            try {
                DB::beginTransaction();

                $User = new User;
                $User->name = $userName;
                $User->uuid = \Ramsey\Uuid\Uuid::uuid4();
                $User->email = $email;
                $User->password = bcrypt($password);
                $User->api_token = \Illuminate\Support\Str::random(90);
                $User->role_type = $roleType;
                $User->phone = $phone;
                $User->address = $address;
                $User->avatar_url = $request->get('avatar_url');
                $User->is_enabled = 1;
                $User->save();

                DB::commit();
                $status = 201;
            } catch (\Exception $e) {
                DB::rollBack();
                $message = $e->getMessage();
                $status = 500;
            }
        }

        $Response = new Response('POST', 'users', $status);
        if ($status == 400)
            return $Response->Error([new Error(Error::FIELD_INVALID, $message)]);
        elseif($status != 201)
            return $Response->Error([new Error(Error::ACTION_FAILED, $message)]);

        $userData = $this->FilterData([$User])[0];
        return $Response->Success($userData);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $LoggedUser = \Auth::guard('api')->user();

        $status = 200;
        // Customer can see only self
        if(!($User = User::find($id)) instanceof User || ($LoggedUser->role_type != User::ROLE_ADMIN && $LoggedUser->id != $User->id)) {
            $Response = new Response('GET', 'users', 403);
            return $Response->Error([new Error(Error::PERMISSION_DENIED)]);
        }

        $Response = new Response('GET', 'users', $status);
        if($status != 200)
            return $Response->Error([new Error(Error::RESOURCE_NOT_FOUND)]);

        $userData = $this->FilterData([$User])[0];

        return $Response->Success($userData);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $LoggedUser = \Auth::guard('api')->user();
        if($LoggedUser->role_type != User::ROLE_ADMIN && $LoggedUser->id != $id ) {
            $Response = new Response('PUT', 'users', 403);
            return $Response->Error([new Error(Error::PERMISSION_DENIED)]);
        }

        $message = '';
        $User = User::find($id);
        if(!$User instanceof User) {
            $status = 404;
        } else {
            $password = $request->exists('password') ? $request->get('password') : $User->password;
            $phone = $request->exists('phone') ? $request->get('phone') : $User->phone;
            $address = $request->exists('address') ? $request->get('address') : $User->address;
            $avatarUrl = $request->exists('avatar_url') ? $request->get('avatar_url') : $User->avatar_url;
            if($request->exists('password') && empty($password)) {
                $status = 400;
                $message = 'Password can not be blank';
            } else {
                $User->phone = $phone;
                $User->address = $address;
                $User->avatar_url = $avatarUrl;
                $User->last_activity_at = date("Y-m-d H:i:s");
                if(!empty($password)) {
                    $User->password = Hash::make($password);
                    $User->password_updated_at = date("Y-m-d H:i:s");
                }

                try {
                    DB::beginTransaction();
                    $User->save();
                    DB::commit();
                    $status = 200;
                } catch (\Exception $e) {
                    DB::rollBack();
                    $message = $e->getMessage();
                    $status = 500;
                }
            }
        }

        $Response = new Response('PUT', 'users', $status);
        if($status == 400)
            return $Response->Error([new Error(Error::FIELD_INVALID, $message)]);
        else if($status == 404)
            return $Response->Error([new Error(Error::RESOURCE_NOT_FOUND, $message)]);
        else if($status == 500)
            return $Response->Error([new Error(Error::ACTION_FAILED, $message)]);

        return $Response->Error([new Error(Error::FIELD_INVALID, $message)]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $LoggedUser = \Auth::guard('api')->user();

        // Customer can't delete itself
        if($LoggedUser->role_type != User::ROLE_ADMIN) {
            $Response = new Response('DELETE', 'users', 403);
            return $Response->Error([new Error(Error::PERMISSION_DENIED)]);
        } else {
            $message = '';
            $User = User::find($id);
            if($User instanceof User) {
                try {
                    DB::beginTransaction();
                    $User->delete();
                    DB::commit();
                    $status = 200;
                } catch (\Exception $e) {
                    DB::rollBack();
                    $message = $e->getMessage();
                    $status = 500;
                }
            } else {
                $status = 404;
            }
        }

        $Response = new Response('DELETE', 'users', $status);
        if($status == 404)
            return $Response->Error([new Error(Error::RESOURCE_NOT_FOUND)]);
        else if($status == 500)
            return $Response->Error([new Error(Error::ACTION_FAILED, $message)]);

        return $Response->Success([]);
    }

    /**
     * Filer user data before sending to api responses
     * @param array $Users
     * @return array
     * @throws \Exception
     */
    private function FilterData(array $Users) {
        $data = [];
        foreach ($Users as $User) {
            $userData = $User;
            if($User instanceof User) {
                $userData = $User->getAttributes();
            }

            unset($userData['password'], $userData['token'], $userData['remember_token']);
            $data[] = $userData;
        }

        return $data;
    }
}
