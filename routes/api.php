<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\BannerController;
use App\Http\Controllers\API\FilterController;
use App\Http\Controllers\API\AboutUsController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\SectionController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\ContactUsController;
use App\Http\Controllers\API\OrderRequestController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::group(['prefix' => 'v1','namespace' => 'API'],function(){

    Route::group(['middleware' => 'auth:api'],function(){

        //Home Category
        Route::get('categories/home' , [CategoryController::class, 'homeCategory']);

        //Main Category
        Route::get('categories' , [CategoryController::class, 'index']);

        //Sub Category
        Route::get('category/{id}' , [CategoryController::class, 'singleCategory']);

        // Home Sections
        // Route::get('sections/home' , [SectionController::class, 'homeSection']);

        // Sections
        Route::get('sections' , [SectionController::class, 'section']);

        // Sections/products
        Route::get('section/{id}' , [SectionController::class, 'sectionSingle']);

        //Products
        Route::get('products' , [ProductController::class, 'index']);

        //Single Product
        Route::get('product/{id}' ,[ProductController::class, 'single']);

        //Banners
        Route::get('banners' , [BannerController::class , 'index']);

        //Contact Us
        Route::post('contacts' , [ContactUsController::class, 'contact']);

        //About Us
        Route::get('abouts' , [AboutUsController::class, 'about']);

        //Privacy
        Route::get('privacy' , [AboutUsController::class, 'privacy']);

        //Order Request
        Route::post('order_request' , [OrderRequestController::class, 'store']);

        //Filter
        // Route::get('filters' , [FilterController::class, 'filter']);


    });
});
