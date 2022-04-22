<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*-----------------  site routes -----------------*/

//Route::get('/quiz','\App\Http\Controllers\quizController@index');



Route::get('/', \App\Modules\Portal\Controllers\HomeController::class . '@index')->name('home');
Route::get('/lang/{locale?}', \App\Modules\Portal\Controllers\HomeController::class . '@changeHomeLang')->name('change_language');
Route::get('blog/categories', \App\Modules\Portal\Controllers\BlogController::class . '@categories')->name('allcategory');

Route::get('blog/{blog_id}', \App\Modules\Portal\Controllers\BlogController::class . '@blog')->name('blog');
Route::get('blog/cat/{cat_id}', \App\Modules\Portal\Controllers\BlogController::class . '@blog_cat')->name('blog_cat');

Route::get('services/{service_id}', \App\Modules\Portal\Controllers\HomeController::class . '@service')->name('service');
Route::get('sub-page/{page_id}', \App\Modules\Portal\Controllers\BlogController::class . '@sub_page')->name('sub_page');
Route::get('contact-us', [\App\Modules\Portal\Controllers\ContactController::class, 'contact_us'])->name('contact');
Route::post('contact-us', [\App\Modules\Portal\Controllers\ContactController::class, 'contactSave'])->name('contact.post');
Route::post('subscribe', [\App\Modules\Portal\Controllers\MailingListController::class, 'store'])->name('subscribe.store');

Route::get('product/categories', [\App\Modules\Portal\Controllers\ProductsController::class, 'categoryProduct'])->name('categories_products');

Route::get('page/{id}', [\App\Modules\Portal\Controllers\PageController::class, 'index'])->name('site.page.show');

Route::get('cat/{cat_id}', [\App\Modules\Portal\Controllers\ProductsController::class, 'category'])->name('cat_product');
Route::get('product/{pro_id}', [\App\Modules\Portal\Controllers\ProductsController::class, 'product'])->name('product');
Route::get('search', [\App\Modules\Portal\Controllers\SearchController::class, 'search'])->name('search');
Route::any('dealers', [\App\Modules\Portal\Controllers\DealersController::class, 'index'])->name('dealers.index');


Route::get('/jobs', \App\Modules\Portal\Controllers\JobsController::class . '@jobs')->name('jobs');
Route::get('/job/{id}', \App\Modules\Portal\Controllers\JobsController::class . '@singleJob')->name('single_job');

Route::middleware(['throttle:2,1'])->group(function () {
    Route::post('/job/uploadFile', \App\Modules\Portal\Controllers\JobsController::class . '@uploadFile')->name('upload.file.job');
});
//Route::middleware(['throttle:ip_address'])->group(function () {
//    Route::post('/job/uploadFile', \App\Modules\Portal\Controllers\JobsController::class . '@uploadFile')->name('upload.file.job');
//});

Route::get('/aboutus', \App\Modules\Portal\Controllers\AboutUsController::class . '@index')->name('aboutus');

