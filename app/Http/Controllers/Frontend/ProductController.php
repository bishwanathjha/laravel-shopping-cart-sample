<?php

namespace App\Http\Controllers\Frontend;

/**
 * Class HomeController
 * @package App\Http\Controllers\Frontend
 */
class ProductController extends BaseController
{
    public function details($id) {
        if(empty($id))
            $this->RenderError();

        $this->LoadUserToken();
        $request = \Request::create('/api/v1/products/' . $id);
        $response =  \Route::dispatch($request);
        $product = json_decode($response->getContent(), true);
        if(!$response->isSuccessful() || $product['status'] != 200) {
            $this->RenderError();
        }

        return view('frontend/product-detail', ['product' => $product['data']]);
    }

    public function cart() {
        $this->LoadUserToken();
        return view('frontend/cart', ['products' => $this->GetData()]);
    }

    private function GetData() {
        $token = $_COOKIE['user_token'];
        $request = \Request::create('/api/v1/cart', 'GET', ['token' => $token]);
        $response =  \Route::dispatch($request);
        $products = json_decode($response->getContent(), true);
        if(!$response->isSuccessful() || $products['status'] != 200) {
            $this->RenderError();
        }

        return $products['data'];
    }

    public function checkout() {
        return view('frontend/cart-checkout', ['products' => $this->GetData()]);
    }

}