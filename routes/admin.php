<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Admin\Controllers\AdminController;
use App\Modules\Admin\Controllers\LanguageController;
use App\Modules\Admin\Controllers\SectionsController;
use App\Modules\Admin\Controllers\DashboardController;
use App\Modules\Admin\Controllers\Jobs\JobsController;
use App\Modules\Admin\Controllers\AdminLoginController;
use App\Modules\Admin\Controllers\Blogs\BlogController;
use App\Modules\Admin\Controllers\Roles\RoleController;
use App\Modules\Admin\Controllers\Blogs\BlogsController;
use App\Modules\Admin\Controllers\Pages\PagesController;
use App\Modules\Admin\Controllers\Roles\RolesController;
use App\Modules\Admin\Controllers\Users\UsersController;
use App\Modules\Admin\Controllers\ImageAccountController;
use App\Modules\Admin\Controllers\ImageSettingController;
use App\Modules\Admin\Controllers\Product\LabelsController;
use App\Modules\Admin\Controllers\Settings\CitiesController;
use App\Modules\Admin\Controllers\Contact\ContactsController;
use App\Modules\Admin\Controllers\Product\ProductsController;
use App\Modules\Admin\Controllers\Services\ServiceController;
use App\Modules\Admin\Controllers\Settings\BannersController;
use App\Modules\Admin\Controllers\Settings\SettingsController;
use App\Modules\Admin\Controllers\Order\OrderRequestController;
use App\Modules\Admin\Controllers\Categories\CategoryController;
use App\Modules\Admin\Controllers\Permissions\PermissionsController;

Route::prefix('admin')->group(function () {
    Route::get('/lang/{locale?}', [DashboardController::class, 'changeLang']);
    Route::get('login', [AdminLoginController::class, 'login'])->name('admin.login');
    Route::post('login', [AdminLoginController::class, 'doLogin'])->name('admin.do.login');

    Route::group(['middleware' => ['auth:admin']], function () {

        Route::get('profile/{id}', [AdminController::class, 'editProfile'])->name('admin.editProfile');
        Route::post('profilePassword', [AdminController::class, 'updatePassword'])->name('admin.updatePassword');
        Route::post('profile', [AdminController::class, 'updateprofile'])->name('admin.updateprofile');

        Route::get('all_users', [UsersController::class, 'index'])->name('users.any');
        Route::post('change_user_activity', [UsersController::class, 'update'])->name('users.activity');
        Route::post('change_user_password', [UsersController::class, 'change_pass'])->name('users.password');

        Route::get('logout', [AdminLoginController::class, 'logout'])->name('admin.logout');

        Route::get('/', [DashboardController::class, 'index'])->name('admin.home')->middleware(['permission:Dashboard']);
        Route::get('/salesSearch', [DashboardController::class, 'salesSearch'])->name('admin.salesSearch')->middleware(['permission:Dashboard']);
        Route::get('/wordsSearch', [DashboardController::class, 'wordsSearch'])->name('admin.wordsSearch')->middleware(['permission:Dashboard']);
        Route::get('/lastOrders', [DashboardController::class, 'lastOrders'])->name('admin.lastOrders')->middleware(['permission:Dashboard']);
        Route::get('/soldProducts', [DashboardController::class, 'soldProducts'])->name('admin.soldProducts')->middleware(['permission:Dashboard']);
        Route::get('/bestSellingProducts', [DashboardController::class, 'bestSellingProducts'])->name('admin.bestSellingProducts')->middleware(['permission:Dashboard']);
        Route::get('/totalOrders', [DashboardController::class, 'totalOrders'])->name('admin.totalOrders')->middleware(['permission:Dashboard']);
        Route::get('/ordersFilterByStatus', [DashboardController::class, 'ordersFilterByStatus'])->name('admin.ordersFilterByStatus')->middleware(['permission:Dashboard']);
        Route::get('/get_cities', [DashboardController::class, 'get_cities'])->name('admin.get_cities')->middleware(['permission:Dashboard']);
        Route::get('/mostViewedProducts', [DashboardController::class, 'mostViewedProducts'])->name('admin.mostViewedProducts')->middleware(['permission:Dashboard']);

        Route::get('language/getLang', [LanguageController::class, 'getLang'])->name('admin.get.lang');

        Route::get('services', [ServiceController::class, 'index'])->name('services.index');
        Route::post('services/store', [ServiceController::class, 'store'])->name('service.store');
        Route::post('services/store_attach', [ServiceController::class, 'store_attach'])->name('service.attach');
        Route::get('service/{id}/edit', [ServiceController::class, 'edit'])->name('service.edit');
        Route::post('service/update', [ServiceController::class, 'update'])->name('service.update')->middleware(['permission:Pages']);
        Route::get('service/{id}', [ServiceController::class, 'delete'])->name('service.delete');
        Route::get('services/get_translation', [ServiceController::class, 'getTranslation'])->name('services.get.translation');
        Route::post('services/store_translation', [ServiceController::class, 'storeTranslation'])->name('services.store.translation');

        Route::get('jobs', [JobsController::class, 'index'])->name('jobs.index');
        Route::post('jobs/store', [JobsController::class, 'store'])->name('jobs.store');
        Route::post('jobs/store_attach', [JobsController::class, 'store_attach'])->name('jobs.attach');
        Route::get('jobs/{id}/edit', [JobsController::class, 'edit'])->name('jobs.edit');
        Route::post('jobs/update', [JobsController::class, 'update'])->name('jobs.update')->middleware(['permission:Pages']);
        Route::get('jobs/{id}', [JobsController::class, 'delete'])->name('jobs.delete');
        Route::get('jobs/get_translation', [JobsController::class, 'getTranslation'])->name('jobs.get.translation');
        Route::post('jobs/store_translation', [JobsController::class, 'storeTranslation'])->name('jobs.store.translation');
        Route::get('job/{id}', [JobsController::class, 'show'])->name('jobs.show');

        //Order Requests

        Route::get('order_request', [OrderRequestController::class, 'index'])->name('order_request.index');
        Route::get('order_request/{id}', [OrderRequestController::class, 'show'])->name('order_request.show');

        Route::get('blogs', [BlogController::class, 'index'])->name('blogs.index')->middleware('permission:Blog');
        Route::post('blogs/store', [BlogController::class, 'store'])->name('blogs.store')->middleware('permission:Blog');
        Route::post('blogs/store_attach', [BlogController::class, 'store_attach'])->name('blogs.attach')->middleware('permission:Blog');
        Route::get('blogs/{id}/edit', [BlogController::class, 'edit'])->name('blogs.edit')->middleware('permission:Blog');
        Route::post('blogs/update', [BlogController::class, 'update'])->name('blogs.update')->middleware('permission:Blog');
        Route::get('blogs/{id}', [BlogController::class, 'delete'])->name('blogs.delete')->middleware('permission:Blog');
        Route::get('blogs/get_translation', [BlogController::class, 'getTranslation'])->name('blogs.get.translation')->middleware('permission:Blog');
        Route::post('blogs/store_translation', [BlogController::class, 'storeTranslation'])->name('blogs.store.translation')->middleware('permission:Blog');

        Route::get('blogs_categories', [BlogsController::class, 'index'])->name('blogs_categories.index')->middleware('permission:Blog');
        Route::post('blogs_categories/store', [BlogsController::class, 'store'])->name('blogs_categories.store')->middleware('permission:Blog');
        Route::post('blogs_categories/store_attach', [BlogsController::class, 'store_attach'])->name('blogs_categories.attach')->middleware('permission:Blog');
        Route::get('blogs_categories/{id}/edit', [BlogsController::class, 'edit'])->name('blogs_categories.edit')->middleware('permission:Blog');
        Route::post('blogs_categories/update', [BlogsController::class, 'update'])->name('blogs_categories.update')->middleware('permission:Blog');
        Route::get('blogs_categories/{id}', [BlogsController::class, 'delete'])->name('blogs_categories.delete')->middleware('permission:Blog');
        Route::get('blogs_categories/get_translation', [BlogsController::class, 'getTranslation'])->name('blogs_categories.get.translation')->middleware('permission:Blog');
        Route::post('blogs_categories/store_translation', [BlogsController::class, 'storeTranslation'])->name('blogs_categories.store.translation')->middleware('permission:Blog');

        Route::get('get/lang', [ProductsController::class, 'getlang'])->name('all_langs');
        Route::get('getTranslateDetail', [LabelsController::class, 'getTranslateDetail'])->name('admin.getTranslateDetail.index');
        Route::post('translateStore', [LabelsController::class, 'storeTranslate'])->name('admin.translation.store');

        Route::get('categories', [CategoryController::class, 'index'])->name('categories.index')->middleware(['permission:Products']);
        Route::get('categories/create', [CategoryController::class, 'create'])->name('categories.create')->middleware(['permission:Products']);
        Route::get('categories/{brand}/edit', [CategoryController::class, 'edit'])->name('categories.edit')->middleware(['permission:Products']);
        Route::post('categories', [CategoryController::class, 'store'])->name('categories.store')->middleware(['permission:Products']);
        Route::patch('categories/{brand}', [CategoryController::class, 'update'])->name('categories.update')->middleware(['permission:Products']);
        Route::delete('categories/{brand}', [CategoryController::class, 'destroy'])->name('categories.destroy')->middleware(['permission:Products']);
        Route::post('categories/store_translation', [CategoryController::class, 'storeTranslation'])->name('categories.store.translation')->middleware(['permission:Products']);
        Route::get('categories/get_translation', [CategoryController::class, 'getTranslation'])->name('categories.get.translation')->middleware(['permission:Products']);
        Route::get('categories/{category}/delete', [CategoryController::class, 'deleteCategory'])->middleware(['permission:Products']);
        Route::post('categories/{category}/image', [CategoryController::class, 'uploadImage'])->name('categories.image.upload')->middleware(['permission:Products']);
        Route::get('category/{id}/features', [CategoryController::class, 'features'])->name('category.features');
        Route::post('category/update/feature', [CategoryController::class, 'featuresPost'])->name('category.update.feature');
        Route::post('create/category/v2', [CategoryController::class, 'createSingleV2'])->name('create.category.v2');
        Route::post('category/orders/update', [CategoryController::class, 'updateOrder'])->name('category.order.update');
        //Banners

        Route::get('settings/banners', [BannersController::class, 'index'])->name('banner.index');
        Route::post('settings/banners/store', [BannersController::class, 'store']);
        Route::post('settings/banners/update', [BannersController::class, 'update']);
        Route::get('settings/banners/get/lang/value', [BannersController::class, 'getLangValue']);
        Route::post('settings/banners/lang/store', [BannersController::class, 'storelangTranslation']);
        Route::delete('settings/banners/{id}', [BannersController::class, 'delete'])->name('banner.destroy');

        Route::get('settings/section/', [SectionsController::class, 'mobileSection'])->name('section.mobile');
        Route::get('settings/section/{section}', [SectionsController::class, 'index'])->name('section.index');
        Route::post('settings/sections/store/home_sections', [SectionsController::class, 'store']);
        Route::post('settings/sections/update', [SectionsController::class, 'update']);
        Route::get('settings/sections/get/lang/value', [SectionsController::class, 'getLangValue']);
        Route::post('settings/sections/lang/store', [SectionsController::class, 'storelangTranslation']);
        Route::delete('settings/sections/{id}', [SectionsController::class, 'delete'])->name('section.destroy');

        Route::get('settings/sections/autocomplete', [SectionsController::class, 'autocomplete']);
        Route::get('settings/section/create/home_sections', [SectionsController::class, 'create'])->name('settings.sections.create');
        Route::get('settings/section/edit/{id}', [SectionsController::class, 'edit'])->name('settings.sections.edit');

        Route::get('pages', [PagesController::class, 'index'])->name('pages.index')->middleware(['permission:Pages']);
        Route::get('pages/create', [PagesController::class, 'create'])->name('pages.create')->middleware(['permission:Pages']);
        Route::post('pages/store', [PagesController::class, 'store'])->name('pages.store')->middleware(['permission:Pages']);
        Route::get('pages/{id}/edit', [PagesController::class, 'edit'])->name('pages.edit');
        Route::post('pages/update/{id}', [PagesController::class, 'update'])->name('pages.update')->middleware(['permission:Pages']);
        Route::delete('pages/{id}', [PagesController::class, 'delete'])->name('pages.destroy')->middleware(['permission:Pages']);
        Route::get('pages/get/lang/value', [PagesController::class, 'pagergetLangvalue'])->name('page_lang_value')->middleware(['permission:Pages']);
        Route::post('pages/lang/store', [PagesController::class, 'pagestorelangTranslation'])->name('page_lang_store')->middleware(['permission:Pages']);

        Route::get('/contacts', [ContactsController::class, 'index'])->name('contacts.index');
        Route::get('/contacts/{id}', [ContactsController::class, 'show'])->name('contacts.show');
        Route::get('contacts/{id}/delete', [ContactsController::class, 'delete'])->name('contacts.delete');

        Route::get('settings', [SettingsController::class, 'index'])->name('settings.index')->middleware(['permission:Settings']);
        Route::get('settings/get', [SettingsController::class, 'get_settings'])->name('settings.edit')->middleware(['permission:Settings']);
        Route::patch('settings/get', [SettingsController::class, 'updateSettings'])->name('settings.update')->middleware(['permission:Settings']);
        Route::get('settings/translation', [SettingsController::class, 'getSettingsTranslation'])->name('settings.translation')->middleware(['permission:Settings']);
        Route::patch('settings/translation', [SettingsController::class, 'updateSettingsTranslation'])->name('settings.update_translation')->middleware(['permission:Settings']);
        Route::post('settings/save_domain', [SettingsController::class, 'saveDomain'])->name('settings.saveDomain')->middleware(['permission:Settings']);
        Route::get('settings/check', [SettingsController::class, 'check'])->middleware(['permission:Settings']);

        Route::get('default/images', [ImageSettingController::class, 'index'])->name('default.images.index');
        Route::post('default/images/edit/{name}/{id}', [ImageSettingController::class, 'edit'])->name('admin.default.images.edit');
        Route::post('settings/image_account/edit', [ImageAccountController::class, 'edit'])->name('admin.image.account.edit')->middleware('permission:Settings');

        Route::get('/cities', [CitiesController::class, 'index'])
            ->name('cities.index')->middleware(['permission:Cities']);
        Route::post('/cities_store', [CitiesController::class, 'store'])
            ->name('cities.store')->middleware(['permission:Cities']);
        Route::post('/cities_update', [CitiesController::class, 'update'])
            ->name('cities.update')->middleware(['permission:Cities']);
        Route::post('city_translate', [CitiesController::class, 'translate'])
            ->name('cities.translate')->middleware(['permission:Cities']);
        Route::post('/cities_delete', [CitiesController::class, 'destroy'])
            ->name('cities.destroy')->middleware(['permission:Cities']);

        Route::get('permissions', [PermissionsController::class, 'index'])->name('site.admin.permissions');
        Route::post('permissions', [PermissionsController::class, 'store'])->name('site.admin.permissions.store');
        Route::patch('permissions/update', [PermissionsController::class, 'update'])->name('site.admin.permissions.update');
        Route::post('permissions/store_translation', [PermissionsController::class, 'storeTranslation'])->name('site.admin.permissions.storeTranslation');
        Route::get('permissions/getLangValue', [PermissionsController::class, 'getLangValue'])->name('site.admin.permissions.getLangValue');
        Route::delete('permissions/{id}/delete', [PermissionsController::class, 'delete'])->name('site.admin.permissions.delete');

        Route::get('roles', [RolesController::class, 'index'])->name('site.admin.roles');
        Route::get('roles/create', [RolesController::class, 'create'])->name('site.admin.roles.create');
        Route::get('roles/{id}', [RolesController::class, 'edit'])->name('site.admin.roles.edit');
        Route::post('roles', [RolesController::class, 'store'])->name('site.admin.roles.store');
        Route::post('roles/{id}', [RolesController::class, 'update'])->name('site.admin.roles.update');
        Route::delete('roles/{id}/delete', [RolesController::class, 'destroy'])->name('site.admin.roles.destroy');
        Route::get('roles/get_permissions/{lang}', [RolesController::class, 'getPermissions']);

        Route::get('role/dataTable', [RoleController::class, 'dataTable']);
        Route::get('role/export', [RoleController::class, 'export'])->name('role.export');

        Route::get('admin', [\App\Modules\Admin\Controllers\Roles\AdminController::class, 'index'])->name('admin.index')
//            ->middleware(['permission:Admins']);
        ;
        Route::get('admin/export', [\App\Modules\Admin\Controllers\Roles\AdminController::class, 'export'])->name('admin.export');
        Route::get('admin/create', [\App\Modules\Admin\Controllers\Roles\AdminController::class, 'create'])->name('admin.create');
        Route::get('admin/{user}/edit', [\App\Modules\Admin\Controllers\Roles\AdminController::class, 'edit'])->name('admin.edit');
        Route::post('admin', [\App\Modules\Admin\Controllers\Roles\AdminController::class, 'store'])->name('admin.store');
        Route::patch('admin/{user}', [\App\Modules\Admin\Controllers\Roles\AdminController::class, 'update'])->name('admin.update');
        Route::patch('admin/{user}/change_password', [\App\Modules\Admin\Controllers\Roles\AdminController::class, 'changePassword'])->name('admin.change_password');
        Route::get('admin/{id}', [\App\Modules\Admin\Controllers\Roles\AdminController::class, 'destroy'])->name('admin.destroy');

        Route::get('role/get_permissions/{lang}', [RoleController::class, 'getPermissions']);
        Route::resource('role', RoleController::class);

    });
});
