<?php

use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\ProductController;

// All route names are prefixed with 'admin.'.
Route::redirect('/', '/admin/dashboard', 301);
Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');


Route::resource('clients', 'ClientController');
Route::resource('distributors', 'DistributorController');
Route::resource('salesReps', 'DistributorController');
Route::resource('customers', 'DistributorController');
Route::resource('categories', 'CategoryController');
Route::resource('products', 'ProductController');

Route::get('createmultiple', [ProductController::class, 'createMultiple'])->name('products.createmultiple');
Route::post('storeupload', [ProductController::class, 'storeUpload'])->name('products.storeupload');
Route::get('/downloadproducttemplate', 'ProductController@getDownload')->name('products.downloadproducttemplate');
    











Route::resource('distributors', 'Backend\DistributorController');

Route::resource('distributors', 'DistributorController');

Route::resource('salesReps', 'SalesRepController');

Route::resource('customers', 'CustomerController');

Route::resource('customers', 'CustomerController');

Route::resource('categories', 'CategoryController');

Route::resource('products', 'ProductController');


Route::resource('salesReps', 'SalesRepController');

Route::resource('paymentMethods', 'PaymentMethodsController');

Route::resource('customers', 'CustomerController');

Route::resource('customerSaleStructrures', 'CustomerSaleStructrureController');

Route::resource('orders', 'OrderController');

Route::resource('orderDetails', 'OrderDetailController');