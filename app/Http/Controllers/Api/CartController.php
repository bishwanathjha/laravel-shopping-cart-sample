<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Library\Api\Error;
use App\Library\Api\Response;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

/**
 * Class ProductController
 * @package App\Http\Controllers\Api
 */
class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $User = \Auth::guard('api')->user();
        $userID = $User instanceof User ? $User->id : null;
        $token = '';

        // Look into parameter otherwise fallback to cookies
        if(Input::exists('token'))
            $token = Input::get('token');
        else if(!empty($_COOKIE['user_token']))
            $token = $_COOKIE['user_token'];

        if(empty($userID) && empty($token)) {
            $Response = new Response('POST', 'cart', 400);
            return $Response->Error([new Error(Error::FIELD_REQUIRED, 'Active session required or visitor token need to be passed')]);
        }

        if(!empty($userID))
            $Order = Order::where('user_id', $userID)->get();
        else if(!empty($token))
            $Order = Order::where('token', $token)->get();

        $ProductData = $Order->toArray();
        $Response = new Response('GET', 'cart', 200);

        $data = [];
        if(!empty($ProductData)) {
            $data = $ProductData;
            $Response->SetPaginated(count($ProductData), count($ProductData), 0);
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
        $productID = $request->get('product_id');
        $User = \Auth::guard('api')->user();
        $userID = $User instanceof User ? $User->id : null;

        // Look into parameter otherwise fallback to cookies
        if(Input::exists('token'))
            $token = Input::get('token');
        else if(!empty($_COOKIE['user_token']))
            $token = $_COOKIE['user_token'];

        if(empty($productID)) {
            $Response = new Response('POST', 'cart', 400);
            return $Response->Error([new Error(Error::FIELD_EMPTY, 'product_id is missing')]);
        }

        if(empty($userID) && empty($token)) {
            $Response = new Response('POST', 'cart', 400);
            return $Response->Error([new Error(Error::FIELD_REQUIRED, 'Active session required or visitor token need to be passed')]);
        }

        // Check if order is already added to the cart
        if($token) {
            $Order = Order::where('token', $token)
                            ->where('product_id', $productID)
                            ->get()
                            ->toArray();
        } else {
            $Order = Order::where('user_id', $userID)
                        ->where('product_id', $productID)
                        ->get()
                        ->toArray();
        }

        if(!empty($Order)) {
            $Response = new Response('POST', 'cart', 400);
            return $Response->Error([new Error(Error::FIELD_INVALID, 'Product is already added to the cart')]);
        }

        $Product = Product::find($productID);
        if($Product instanceof Product) {
            try {
                DB::beginTransaction();
                $Order = new Order;
                $Order->user_id = $userID;
                $Order->token = $token;
                $Order->product_id = $Product->id;
                $Order->product_name = $Product->title;
                $Order->product_desc = $Product->description;
                $Order->unit_price = $Product->original_price;
                $Order->image = $Product->image;
                $Order->quantity = 1;
                $Order->status = 1;
                $Order->added_at = date("Y-m-d H:i:s");
                $Order->save();

                DB::commit();
                $status = 201;
            } catch (\Exception $e) {
                DB::rollBack();
                $message = $e->getMessage();
                $status = 500;
            }
        } else {
            $status = 404;
        }

        $Response = new Response('POST', 'cart', $status);
        if($status == 404)
            return $Response->Error([new Error(Error::RESOURCE_NOT_FOUND)]);
        else if($status == 500)
            return $Response->Error([new Error(Error::ACTION_FAILED, $message)]);

        return $Response->Success($Order->getAttributes());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $token = Input::get('token');
        $LoggedUser = \Auth::guard('api')->user();
        $userID = ($LoggedUser instanceof  User) ? $LoggedUser->id : 0;

        // Look into parameter other fallback to cookies
        if(Input::exists('token'))
            $token = Input::get('token');
        else if(!empty($_COOKIE['user_token']))
            $token = $_COOKIE['user_token'];

        // Check if order is already added to the cart
        if($userID) {
            $Order = Order::where('user_id', $userID)
                ->where('id', $id)
                ->get()
                ->toArray();
        } else {
            $Order = Order::where('token', $token)
                ->where('id', $id)
                ->get()
                ->toArray();
        }
        
        if(empty($Order)) {
            $Response = new Response('POST', 'cart', 400);
            return $Response->Error([new Error(Error::RESOURCE_NOT_FOUND, 'No such item found in cart')]);
        }

        $message = '';
        $Order = Order::find($id);
        if($Order instanceof Order) {
            try {
                DB::beginTransaction();
                $Order->delete();

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

        $Response = new Response('DELETE', 'cart', $status);
        if($status == 404)
            return $Response->Error([new Error(Error::RESOURCE_NOT_FOUND)]);
        else if($status == 500)
            return $Response->Error([new Error(Error::ACTION_FAILED, $message)]);

        return $Response->Success([]);
    }
}
