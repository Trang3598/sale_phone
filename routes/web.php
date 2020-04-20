<?php

use Illuminate\Support\Facades\Broadcast;

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
    Route::resource('slide', 'SlideController');
    Route::resource('c', 'DashboardController');
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
    Route::get('slide/destroy/{slide}', 'SlideController@destroy')->name('slide.delete');

});
//search route
Route::get('category/search', 'CategoryController@search')->name('category.search')->middleware('auth');
Route::get('product/search', 'ProductController@search')->name('product.search')->middleware('auth');
Route::get('image/search', 'ImageController@search')->name('image.search')->middleware('auth');
Route::get('order/search', 'OrderController@search')->name('order.search')->middleware('auth');
Route::get('order_detail/search', 'OrderDetailController@search')->name('order_detail.search')->middleware('auth');
Route::get('color/search', 'ColorController@search')->name('color.search')->middleware('auth');
Route::get('user/search', 'UserController@search')->name('user.search')->middleware('auth');
Route::get('sale_phone/search', 'SalePhoneController@search')->name('sale_phone.search')->middleware('auth');
Route::get('status/search', 'StatusController@search')->name('status.search')->middleware('auth');
Route::get('deliverer/search', 'DelivererController@search')->name('deliverer.search')->middleware('auth');
Route::get('comment/search', 'CommentController@search')->name('comment.search')->middleware('auth');
//see detailed image
Route::get('product/image/{product}', 'ProductController@showImage')->name('product.image')->middleware('auth');
Auth::routes(['verify' => true]);
Route::get('/home', 'HomeController@index')->name('home')->middleware('auth');
Route::get('/permission', function () {
    return view('admin.error.403');
})->name('error.permission');
Route::get('/account', 'UserController@account')->name('user.account');
Route::post('settingAccount/{user}', 'UserController@settingAccount')->name('user.settingAccount');
Route::get('admin/order/detail/{id}', 'OrderController@detail')->name('detail')->middleware('auth');
Route::get('admin/order/add_order_detail/{id}', 'OrderController@addOrderDetail')->name('add_order_detail')->middleware('auth');
Route::post('admin/order/set_price', 'OrderController@setPrice')->name('set_price')->middleware('auth');
Route::post('admin/order/add_order_detail_action/{id}', 'OrderController@addOrderDetailAction')->name('add_order_detail_action')->middleware('auth');
Route::get('admin/order/delete_product_from_cart/{id}', 'OrderController@deleteProductFromCart')->name('delete_product_from_cart')->middleware('auth');
Route::get('admin/order/update_view_order_detail/{id}', 'OrderController@updateViewOrderDetail')->name('update_view_order_detail')->middleware('auth');
Route::post('admin/order/update_order_detail/{id}', 'OrderController@updateOrderDetail')->name('update_order_detail')->middleware('auth');
Route::get('pdf/{id}', 'OrderController@exportPDF')->name('export_pdf')->middleware('auth');
Auth::routes(['except' => 'home.index']);

Route::prefix('chat')->name('client.chat.')->group(function () {
    Route::get('', 'Client\ChatController@index')->name('index')->middleware('auth');
    Route::post('/submit', 'Client\ChatController@submit')->name('submit')->middleware('auth');
});

Route::middleware('auth')->prefix('admin-chat')->name('admin.chat.')->group(function () {
    Route::get('', 'Admin\ChatController@index')->name('index')->middleware('auth');
    Route::post('/submit', 'Admin\ChatController@submit')->name('submit')->middleware('auth');
});
Route::get('callback/{provider}', 'Auth\LoginController@handleProviderCallback');
Route::get('login/{provider}', 'Auth\LoginController@redirect');


Route::group(['prefix' => 'client'], function () {
    Route::get('home', 'Client\HomeController@index')->name('home.index');
    Route::get('detail/{id}', 'Client\HomeController@getDetail')->name('product.detail');
    Route::get('category/product/{id}', 'Client\HomeController@getProduct')->name('category.product');
    Route::get('send-infor', 'Client\HomeController@sendInfor')->name('send.infor');
    Route::post('send', 'Client\HomeController@send')->name('send');
    Route::post('send-comment/{id}', 'Client\HomeController@sendCommentAndImageFeedback')->name('send.comment');
    Route::get('order', 'Client\HomeController@orderItem')->name('order.item');
    Route::get('cart/{id}', 'Client\HomeController@addToCart')->name('cart');
    Route::get('cart/delete/{id}', 'Client\HomeController@getDelItemCart')->name('delete.item');
    Route::post('sendOrder', 'Client\HomeController@sendOrder')->name('send-order');
    Route::get('order/success', 'Client\HomeController@orderSuccess')->name('order-success');
    Route::post('payment', 'Client\HomeController@payment')->name('payment');
    Route::get('cancel', 'Client\HomeController@cancelOrder')->name('order-cancel');
    Route::get('result/{key}', 'Client\HomeController@resultSearch')->name('search-result');
    Route::post('search', 'Client\HomeController@searchItem')->name('search-product');
});
