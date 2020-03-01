<?php
Route::get('/', function () {
    return view('auth.login');
});
Route::group(['prefix' => 'admin', 'middleware' => ['auth']], function () {
    Route::resource('category', 'CategoryController');
    Route::resource('product', 'ProductController');
    Route::resource('order', 'OrderController');
    Route::resource('order_detail', 'OrderDetailController');
    Route::resource('color', 'ColorController');
    Route::resource('user', 'UserController');
    Route::resource('image', 'ImageController');
    Route::resource('sale_phone', 'SalePhoneController');
    Route::resource('status', 'StatusController');
    Route::resource('deliverer', 'DelivererController');
    Route::resource('comment', 'CommentController');
    Route::resource('sale_phone', 'SalePhoneController');
    Route::resource('role', 'RoleController');
    Route::get('image/{image}/showImage', 'ImageController@showImage')->name('image.showImage');
    Route::get('export', 'ProductController@export')->name('product.export');
    //delete route
    Route::get('category/destroy/{category}', 'CategoryController@destroy')->name('category.delete');
    Route::get('product/destroy/{product}', 'ProductController@destroy')->name('product.delete');
    Route::get('image/destroy/{image}', 'ImageController@destroy')->name('image.delete');
    Route::get('order/destroy/{order}', 'OrderController@destroy')->name('order.delete');
    Route::get('order_detail/destroy/{order_detail}', 'OrderDetailController@destroy')->name('order_detail.delete');
    Route::get('color/destroy/{product}', 'ColorController@destroy')->name('color.delete');
    Route::get('user/destroy/{user}', 'UserController@destroy')->name('user.delete');
    Route::get('sale_phone/destroy/{sale_phone}', 'SalePhoneController@destroy')->name('sale_phone.delete');
    Route::get('status/destroy/{status}', 'StatusController@destroy')->name('status.delete');
    Route::get('deliverer/destroy/{deliverer}', 'DelivererController@destroy')->name('deliverer.delete');
    Route::get('comment/destroy/{comment}', 'CommentController@destroy')->name('comment.delete');
    Route::get('role/destroy/{role}', 'RoleController@destroy')->name('role.delete');

});
//search route
Route::get('category/search', 'CategoryController@search')->name('category.search');
Route::get('product/search', 'ProductController@search')->name('product.search');
Route::get('image/search', 'ImageController@search')->name('image.search');
Route::get('order/search', 'OrderController@search')->name('order.search');
Route::get('order_detail/search', 'OrderDetailController@search')->name('order_detail.search');
Route::get('color/search', 'ColorController@search')->name('color.search');
Route::get('user/search', 'UserController@search')->name('user.search');
Route::get('sale_phone/search', 'SalePhoneController@search')->name('sale_phone.search');
Route::get('status/search', 'StatusController@search')->name('status.search');
Route::get('deliverer/search', 'DelivererController@search')->name('deliverer.search');
Route::get('comment/search', 'CommentController@search')->name('comment.search');
//see detailed image
Route::get('product/image/{product}', 'ProductController@showImage')->name('product.image');
Auth::routes(['verify' => true]);
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/permission', function () {
    return view('admin.error.403');
})->name('error.permission');
Route::get('/chat', 'ChatController@chat')->name('chat');
