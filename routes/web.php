 <?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

//$router->get('/', function () use ($router) {
//    return $router->app->version();
//});


 $router->group(['prefix' => 'admin'], function () use ($router){
     $router->post('register', 'AdminController@register');
     $router->post('login', 'AdminController@login');
     $router->get('/posts','PostsController@getPosts');
     $router->group(['middleware'=>'auth1'],function () use ($router){
         $router->post('logout','AdminController@logout');
         $router->delete('/posts/{id}', 'PostsController@deleteAdmin');
     });
 });

 $router->group(['prefix'=>'api'], function () use ($router){
     $router->post('register', 'UserController@register');
     $router->post('login', 'UserController@login');
     $router->get('/posts','PostsController@getPosts');
     $router->group(['middleware'=>'auth'],function () use ($router){
         $router->post('store', 'UserDetailsController@store');
         $router->put('update','UserDetailsController@update');
         $router->post('logout','UserController@logout');
         $router->post('/posts','PostsController@store');
         $router->put('/posts/{id}','PostsController@update');
         $router->delete('/posts/{id}', 'PostsController@delete');
         $router->post('/comments/{id}','CommentsController@store');
         $router->get('/comments/{id}','PostsController@getComments');
         $router->delete('/comments/{id}','CommentsController@delete');
     });
 });
