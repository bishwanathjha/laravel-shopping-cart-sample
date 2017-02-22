<?php

namespace App\Http\Controllers\Frontend;
use Illuminate\Support\Facades\Input;

/**
 * Class HomeController
 * @package App\Http\Controllers\Frontend
 */
class HomeController extends BaseController
{
    /**
     * Application Landing Page
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index() {
        $this->LoadUserToken();
        $request = \Request::create('/api/v1/products');
        $response =  \Route::dispatch($request);
        $products = json_decode($response->getContent(), true);
        if(!$response->isSuccessful() || $products['status'] != 200) {
            $this->RenderError();
        }

        $products['total_pages'] = !empty($products['total_count']) ? ceil($products['total_count'] / 12) : 0;
        $products['current_page'] = Input::exists('page') ? Input::get('page') : 1;

        return view('frontend/home', ['products' => $products]);
    }

}