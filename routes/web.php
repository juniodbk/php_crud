<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Models\Product;


Route::get('/', function () {
    return redirect('products');
});

Route::resource('products', ProductController::class);