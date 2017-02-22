<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Library\Api\Error;
use App\Library\Api\Response;

use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Class ProductController
 * @package App\Http\Controllers\Api
 */
class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ProductData = Product::paginate(12)->toArray();
        $Response = new Response('GET', 'products', 200);

        $data = [];
        if(!empty($ProductData['data'])) {
            $data = $ProductData['data'];
            $Response->SetPaginated($ProductData['total'], 12, $ProductData['from'] -1 );
        }

        return $Response->Success($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $status = 200;
        $Product = Product::find($id);
        if(!$Product instanceof Product) {
            $status = 404;
        }

        $Response = new Response('GET', 'products', $status);
        if($status != 200)
            return $Response->Error([new Error(Error::RESOURCE_NOT_FOUND)]);

        return $Response->Success($Product->getAttributes());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $LoggedUser = \Auth::guard('api')->user();
        if($LoggedUser->role_type != User::ROLE_ADMIN) {
            $Response = new Response('PUT', 'users', 403);
            return $Response->Error([new Error(Error::PERMISSION_DENIED)]);
        }

        $message = $status = '';
        $title = $request->get('title');
        $description = $request->get('description');
        $category = $request->exists('category') ? $request->get('category') : 'General';
        $originalPrice = $request->get('original_price');
        $actualPrice = $request->get('actual_price');
        $image = $request->get('image');
        $quantity = $request->get('quantity');
        $inStock = $request->get('in_stock');
        $sellerName = $request->get('seller_name');

        /**
         * @todo Improve error handling field wise like invalid or required
         */
        if(empty($title) || empty($description) || empty($originalPrice) || empty($actualPrice)
            || empty($image) || empty($quantity) || empty($inStock) || empty($sellerName)) {
            $status = 400;
            $message = 'Mandatory fields are missing like (title, description, original_price, actual_price, image, quantity, in_stock, seller_name)';
        }

        if(empty($status)) {
            try {
                DB::beginTransaction();

                $Product = new Product;
                $Product->title = $title;
                $Product->uuid = \Ramsey\Uuid\Uuid::uuid4();
                $Product->description = $description;
                $Product->category = $category;
                $Product->original_price = $originalPrice;
                $Product->actual_price = $actualPrice;
                $Product->image = $image;
                $Product->quantity = $quantity;
                $Product->in_stock = $inStock;
                $Product->seller_name = $sellerName;
                $Product->save();

                DB::commit();
                $status = 201;
            } catch (\Exception $e) {
                DB::rollBack();
                $message = $e->getMessage();
                $status = 500;
            }
        }

        $Response = new Response('POST', 'products', $status);
        if ($status == 400)
            return $Response->Error([new Error(Error::FIELD_REQUIRED, $message)]);
        elseif($status != 201)
            return $Response->Error([new Error(Error::ACTION_FAILED, $message)]);

        return $Response->Success($Product->getAttributes());
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
        if($LoggedUser->role_type != User::ROLE_ADMIN) {
            $Response = new Response('PUT', 'users', 403);
            return $Response->Error([new Error(Error::PERMISSION_DENIED)]);
        }

        $message = '';
        $Product = Product::find($id);
        if(!$Product instanceof Product) {
            $status = 404;
        } else {
            $title = $request->exists('title') ? $request->get('title') : $Product->title;
            $description = $request->exists('description') ? $request->get('description') : $Product->description;
            $category = $request->exists('category') ? $request->get('category') : $Product->category;
            $originalPrice = $request->exists('original_price') ? $request->get('original_price') : $Product->original_price;
            $actualPrice = $request->exists('actual_price') ? $request->get('actual_price') : $Product->actual_price;
            $image = $request->exists('image') ? $request->get('image') : $Product->image;
            $quantity = $request->exists('quantity') ? $request->get('quantity') : $Product->quantity;
            $inStock = $request->exists('in_stock') ? $request->get('in_stock') : $Product->in_stock;
            $sellerName = $request->exists('seller_name') ? $request->get('seller_name') : $Product->seller_name;

            $Product->title = $title;
            $Product->description = $description;
            $Product->category = $category;
            $Product->original_price = $originalPrice;
            $Product->actual_price = $actualPrice;
            $Product->image = $image;
            $Product->quantity = $quantity;
            $Product->in_stock = $inStock;
            $Product->seller_name = $sellerName;

            try {
                DB::beginTransaction();
                $Product->save();
                DB::commit();
                $status = 200;
            } catch (\Exception $e) {
                DB::rollBack();
                $message = $e->getMessage();
                $status = 500;
            }
        }

        $Response = new Response('PUT', 'products', $status);
        if($status == 400)
            return $Response->Error([new Error(Error::FIELD_INVALID, $message)]);
        else if($status == 404)
            return $Response->Error([new Error(Error::RESOURCE_NOT_FOUND, $message)]);
        else if($status == 500)
            return $Response->Error([new Error(Error::ACTION_FAILED, $message)]);

        return $Response->Success($Product->getAttributes());
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
        if($LoggedUser->role_type != User::ROLE_ADMIN) {
            $Response = new Response('PUT', 'users', 403);
            return $Response->Error([new Error(Error::PERMISSION_DENIED)]);
        }

        $message = '';
        $Product = Product::find($id);
        if($Product instanceof Product) {
            try {
                DB::beginTransaction();
                $Product->delete();
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

        $Response = new Response('DELETE', 'products', $status);
        if($status == 404)
            return $Response->Error([new Error(Error::RESOURCE_NOT_FOUND)]);
        else if($status == 500)
            return $Response->Error([new Error(Error::ACTION_FAILED, $message)]);

        return $Response->Success([]);
    }
}
