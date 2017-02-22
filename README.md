<p align="center"><img src="https://laravel.com/assets/img/components/logo-laravel.svg"></p>

## Laravel shopping cart sample application

An application for learning purposes, Small E-commerce(shopping cart) application using the Laravel framework, which has the following abilities:
- Admin:
a) Ability to create, delete, edit a product
b) Ability to create, delete, edit a user
c) Sign-up & login to the app

- End user:
a) Ability to add products to a shopping cart
b) Ability to view a cart and manage it (add more products, remove existing)
c) Sign-up & login to the app

- Bootstrap is used to build end user interface and powered that through backend API(using javascript/jquery)

## Requirement

- Apache/Nginx as web server
- PHP as backend language
- MySQL as database
- Bootstrap to build frontend UI
- Javascript/Jquery for event handling

## Available routes

➜  laravel-test php artisan route:list
+--------+-----------+----------------------------+------------------+------------------------------------------------------------------------+------------+
| Domain | Method    | URI                        | Name             | Action                                                                 | Middleware |
+--------+-----------+----------------------------+------------------+------------------------------------------------------------------------+------------+
|        | GET|HEAD  | /                          |                  | App\Http\Controllers\Frontend\HomeController@index                     | web        |
|        | GET|HEAD  | admin                      |                  | App\Http\Controllers\Admin\LandingController@index                     | web        |
|        | GET|HEAD  | admin/products/add         |                  | App\Http\Controllers\Admin\LandingController@product_add               | web        |
|        | GET|HEAD  | admin/products/view        |                  | App\Http\Controllers\Admin\LandingController@product_list              | web        |
|        | GET|HEAD  | admin/users/add            |                  | App\Http\Controllers\Admin\LandingController@user_add                  | web        |
|        | GET|HEAD  | admin/users/view           |                  | App\Http\Controllers\Admin\LandingController@user_list                 | web        |
|        | GET|HEAD  | api/login                  | login            | App\Http\Controllers\Auth\LoginController@showLoginForm                | api,guest  |
|        | POST      | api/login                  |                  | App\Http\Controllers\Auth\LoginController@login                        | api,guest  |
|        | POST      | api/logout                 | logout           | App\Http\Controllers\Auth\LoginController@logout                       | api        |
|        | POST      | api/password/email         | password.email   | App\Http\Controllers\Auth\ForgotPasswordController@sendResetLinkEmail  | api,guest  |
|        | GET|HEAD  | api/password/reset         | password.request | App\Http\Controllers\Auth\ForgotPasswordController@showLinkRequestForm | api,guest  |
|        | POST      | api/password/reset         |                  | App\Http\Controllers\Auth\ResetPasswordController@reset                | api,guest  |
|        | GET|HEAD  | api/password/reset/{token} | password.reset   | App\Http\Controllers\Auth\ResetPasswordController@showResetForm        | api,guest  |
|        | POST      | api/register               |                  | App\Http\Controllers\Auth\RegisterController@register                  | api,guest  |
|        | GET|HEAD  | api/register               | register         | App\Http\Controllers\Auth\RegisterController@showRegistrationForm      | api,guest  |
|        | GET|HEAD  | api/v1/cart                | cart.index       | App\Http\Controllers\Api\CartController@index                          | api        |
|        | POST      | api/v1/cart                | cart.store       | App\Http\Controllers\Api\CartController@store                          | api        |
|        | GET|HEAD  | api/v1/cart/create         | cart.create      | App\Http\Controllers\Api\CartController@create                         | api        |
|        | DELETE    | api/v1/cart/{cart}         | cart.destroy     | App\Http\Controllers\Api\CartController@destroy                        | api        |
|        | PUT|PATCH | api/v1/cart/{cart}         | cart.update      | App\Http\Controllers\Api\CartController@update                         | api        |
|        | GET|HEAD  | api/v1/cart/{cart}         | cart.show        | App\Http\Controllers\Api\CartController@show                           | api        |
|        | GET|HEAD  | api/v1/cart/{cart}/edit    | cart.edit        | App\Http\Controllers\Api\CartController@edit                           | api        |
|        | GET|HEAD  | api/v1/products            |                  | App\Http\Controllers\Api\ProductController@index                       | api        |
|        | GET|HEAD  | api/v1/products/{id?}      |                  | App\Http\Controllers\Api\ProductController@show                        | api        |
|        | POST      | api/v1/users               |                  | App\Http\Controllers\Api\UserController@store                          | api        |
|        | GET|HEAD  | cart/checkout              |                  | App\Http\Controllers\Frontend\ProductController@checkout               | web        |
|        | GET|HEAD  | cart/products              |                  | App\Http\Controllers\Frontend\ProductController@cart                   | web        |
|        | GET|HEAD  | home                       |                  | App\Http\Controllers\Frontend\HomeController@index                     | web        |
|        | POST      | login                      |                  | App\Http\Controllers\Auth\LoginController@login                        | web,guest  |
|        | GET|HEAD  | login                      | login            | App\Http\Controllers\Auth\LoginController@showLoginForm                | web,guest  |
|        | POST      | logout                     | logout           | App\Http\Controllers\Auth\LoginController@logout                       | web        |
|        | POST      | password/email             | password.email   | App\Http\Controllers\Auth\ForgotPasswordController@sendResetLinkEmail  | web,guest  |
|        | GET|HEAD  | password/reset             | password.request | App\Http\Controllers\Auth\ForgotPasswordController@showLinkRequestForm | web,guest  |
|        | POST      | password/reset             |                  | App\Http\Controllers\Auth\ResetPasswordController@reset                | web,guest  |
|        | GET|HEAD  | password/reset/{token}     | password.reset   | App\Http\Controllers\Auth\ResetPasswordController@showResetForm        | web,guest  |
|        | GET|HEAD  | products/{id}-{any}        |                  | App\Http\Controllers\Frontend\ProductController@details                | web        |
|        | POST      | register                   |                  | App\Http\Controllers\Auth\RegisterController@register                  | web,guest  |
|        | GET|HEAD  | register                   | register         | App\Http\Controllers\Auth\RegisterController@showRegistrationForm      | web,guest  |
+--------+-----------+----------------------------+------------------+------------------------------------------------------------------------+------------+

## Todo

- Write test cases for api endpoints
- Add api input validation
- Add pagination in admin panel listings
- Add ability to edit user/product from admin panel
- Add proper validations in api processing
- Switch frontend into AngularJS

## License

This is open-sourced project licensed under the [MIT license](http://opensource.org/licenses/MIT).