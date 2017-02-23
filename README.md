<p align="center"><img src="https://laravel.com/assets/img/components/logo-laravel.svg"></p>

## Laravel shopping cart sample application

An application for learning purposes, Small E-commerce(shopping cart) application using the Laravel framework, which has the following abilities:
* Admin:
    * Ability to create, delete, edit a product
    * Ability to create, delete, edit a user
    * Sign-up & login to the app

* End user:
    * Ability to add products to a shopping cart
    * Ability to view a cart and manage it (add more products, remove existing)
    * Sign-up & login to the app

- Bootstrap is used to build end user interface and powered that through backend API(using javascript/jquery)

## Requirement

- Apache/Nginx as web server
- PHP as backend language
- MySQL as database
- Bootstrap to build frontend UI
- Javascript/Jquery for event handling

## How to run it

- CLone the repo
- Create virtual host like(laravel-sample-app.com) and point the URL to `public` folder
- Make sure you have already created mysql database `laravel` or whatever you want set that into `config\database.php`
- Run the `php artisan migrate` this will create required table

## More info

Below are the api endpoints available, they support GET, POST, PUT, DELETE
- /api/v1/users
- /api/v1/products
- /api/v1/cart

For full list of available path(web/api) run this command from root directory `php artisan route:list`

Token based authentication is used to authenticate user in api, Ref: https://gist.github.com/JacobBennett/090369fbab0b31130b51

## Todo

- Write test cases for api endpoints
- Add api input validation
- Add pagination in admin panel listings
- Add ability to edit user/product from admin panel
- Add proper validations in api processing
- Switch frontend into AngularJS

## License

This is open-sourced project licensed under the [MIT license](http://opensource.org/licenses/MIT).