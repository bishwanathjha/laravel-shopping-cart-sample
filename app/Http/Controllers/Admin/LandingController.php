<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

/**
 * Class HomeController
 * @package App\Http\Controllers\Admin
 */
class LandingController extends Controller
{
    public function index() {
        return view('admin/home', []);
    }

    public function user_add() {
        return view('admin/user-add', []);
    }

    public function user_list() {
        $users = file_get_contents(\URL::to('api/v1/users') . '?api_token=' . $_COOKIE['user_api_token']);
        $users = (array) json_decode($users, true);
        if(!isset($users['status']) || $users['status'] != 200) {
            $this->RenderError();
        }

        $users['total_pages'] = !empty($users['total_count']) ? ceil($users['total_count'] / 12) : 0;
        $users['current_page'] = Input::exists('page') ? Input::get('page') : 1;

        return view('admin/user-list', ['users' => $users]);
    }

    public function product_add() {
        return view('admin/product-add', []);
    }

    public function product_list() {
        $products = file_get_contents(\URL::to('api/v1/products') . '?api_token=' . $_COOKIE['user_api_token']);
        $products = (array) json_decode($products, true);
        if(!isset($products['status']) || $products['status'] != 200) {
            $this->RenderError();
        }

        $users['total_pages'] = !empty($products['total_count']) ? ceil($products['total_count'] / 12) : 0;
        $users['current_page'] = Input::exists('page') ? Input::get('page') : 1;

        return view('admin/product-list', ['products' => $products]);

    }

    /**
     * Render 404 error page
     */
    protected function RenderError() {
        echo view('errors/404');
        exit;
    }
}