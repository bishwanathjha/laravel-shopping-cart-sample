<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;

/**
 * Class HomeController
 * @package App\Http\Controllers\Frontend
 */
class BaseController extends Controller
{
    /** @var string */
    protected $userToken;

    /**
     * Just in case of authentication
     *
     * BaseController constructor
     */
    public function __construct() {
        // $this->middleware('auth');
    }

    /**
     * Load user token based on login status
     */
    protected function LoadUserToken() {
        if(!\Auth::check()) {
            $this->userToken = !empty($_COOKIE['user_token']) ? $_COOKIE['user_token'] : '';

            if(empty($this->userToken)) {
                $this->userToken = \Illuminate\Support\Str::random(60);
                setcookie('user_token', $this->userToken,  time() + (10 * 365 * 24 * 60 * 60), '/');
            }
        }
    }

    /**
     * Render 404 error page
     */
    protected function RenderError() {
        echo view('errors/404');
        exit;
    }
}