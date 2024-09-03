<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\LanguageController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\SubCategoryController;
use App\Http\Controllers\Admin\VendorController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\ProductsController;
use App\Http\Controllers\Admin\TagsController;
use App\Http\Controllers\Admin\AttributesController;
use App\Http\Controllers\Admin\OptionsController;
use Illuminate\Support\Facades\Route;


Route::group([
    "prefix"=> "dashboard",
    "middleware"=> ["guest:admin"],
    ], function () {

        Route::get("/login", [AdminController::class, 'getLogin'])->name("dashboard.getlogin");
        Route::post('/login', [AdminController::class,'postLogin'])->name('dashboard.login');
        Route::get('/logout', [AdminController::class, 'getLogout'])->name('dashboard.logout');
    }
);

Route::group([
    'prefix'=> 'dashboard',
    'middleware'=> ['auth:admin']
    ],function(){
        Route::get("/", [DashboardController::class, 'index'])->name("admin.dashboard");

        Route::get('/languages/list', [LanguageController::class, 'list'])->name('dashboard.languages.list');
        Route::get('/languages/add', [LanguageController::class, 'create'])->name('dashboard.languages.add');
        Route::post('/languages/store', [LanguageController::class,'store'])->name('dashboard.languages.store');
        Route::get('/languages/edit/{id}', [LanguageController::class, 'edit'])->name('dashboard.languages.edit');
        Route::post('/languages/update/{id}', [LanguageController::class,'update'])->name('dashboard.languages.update');
        Route::post('/languages/destroy/{id}', [LanguageController::class,'destroy'])->name('dashboard.languages.destroy');

        Route::get('/categories/list', [CategoryController::class, 'list'])->name('dashboard.categories.list');
        Route::get('/categories/add', [CategoryController::class, 'create'])->name('dashboard.categories.add');
        Route::post('/categories/store', [CategoryController::class,'store'])->name('dashboard.categories.store');
        Route::get('/categories/edit/{id}', [CategoryController::class, 'edit'])->name('dashboard.categories.edit');
        Route::post('/categories/update/{id}', [CategoryController::class,'update'])->name('dashboard.categories.update');
        Route::post('/categories/destroy/{id}', [CategoryController::class,'destroy'])->name('dashboard.categories.destroy');

        Route::get('/subcategories/list', [SubCategoryController::class, 'list'])->name('dashboard.subcategories.list');
        Route::get('/subcategories/add', [SubCategoryController::class, 'create'])->name('dashboard.subcategories.add');
        Route::post('/subcategories/store', [SubCategoryController::class,'store'])->name('dashboard.subcategories.store');
        Route::get('/subcategories/edit/{id}', [SubCategoryController::class, 'edit'])->name('dashboard.subcategories.edit');
        Route::post('/subcategories/update/{id}', [SubCategoryController::class,'update'])->name('dashboard.subcategories.update');
        Route::post('/subcategories/destroy/{id}', [SubCategoryController::class,'destroy'])->name('dashboard.subcategories.destroy');

        Route::get('/vendors/list', [VendorController::class, 'list'])->name('dashboard.vendors.list');
        Route::get('/vendors/add', [VendorController::class, 'create'])->name('dashboard.vendors.add');
        Route::post('/vendors/store', [VendorController::class,'store'])->name('dashboard.vendors.store');
        Route::get('/vendors/edit/{id}', [VendorController::class, 'edit'])->name('dashboard.vendors.edit');
        Route::post('/vendors/update/{id}', [VendorController::class,'update'])->name('dashboard.vendors.update');
        Route::post('/vendors/destroy/{id}', [VendorController::class,'destroy'])->name('dashboard.vendors.destroy');

        Route::get('/brands/list', [BrandController::class, 'list'])->name('dashboard.brands.list');
        Route::get('/brands/add', [BrandController::class, 'create'])->name('dashboard.brands.add');
        Route::post('/brands/store', [BrandController::class,'store'])->name('dashboard.brands.store');
        Route::get('/brands/edit/{id}', [BrandController::class, 'edit'])->name('dashboard.brands.edit');
        Route::post('/brands/update/{id}', [BrandController::class,'update'])->name('dashboard.brands.update');
        Route::post('/brands/destroy/{id}', [BrandController::class,'destroy'])->name('dashboard.brands.destroy');

        Route::get('/tags/list', [TagsController::class, 'list'])->name('dashboard.tags.list');
        Route::get('/tags/add', [TagsController::class, 'create'])->name('dashboard.tags.add');
        Route::post('/tags/store', [TagsController::class,'store'])->name('dashboard.tags.store');
        Route::get('/tags/edit/{id}', [TagsController::class, 'edit'])->name('dashboard.tags.edit');
        Route::post('/tags/update/{id}', [TagsController::class,'update'])->name('dashboard.tags.update');
        Route::post('/tags/destroy/{id}', [TagsController::class,'destroy'])->name('dashboard.tags.destroy');

        Route::get('/products/list', [ProductsController::class, 'list'])->name('dashboard.products.list');
        Route::get('/products/general/create', [ProductsController::class, 'create'])->name('dashboard.products.general.create');
        Route::post('/products/general/store', [ProductsController::class,'store'])->name('dashboard.products.general.store');
        Route::get('/products/general/edit/{id}', [ProductsController::class, 'edit'])->name('dashboard.products.general.edit');
        Route::post('/products/general/update/{id}', [ProductsController::class,'update'])->name('dashboard.products.general.update');
        
        Route::get('/product/price/{id}', [ProductsController::class, 'getPrice'])->name('dashboard.products.getprice');
        Route::post('/product/price/store', [ProductsController::class, 'updatePrice'])->name('dashboard.products.updateprice');

        Route::get('/product/stock/{id}', [ProductsController::class, 'getStock'])->name('dashboard.products.getstock');
        Route::post('/product/stock/store', [ProductsController::class, 'updateStock'])->name('dashboard.products.updatestock');

        Route::get('/product/images/{id}', [ProductsController::class, 'getImages'])->name('dashboard.products.getimage');
        Route::post('/product/images/store', [ProductsController::class, 'updateImages'])->name('dashboard.products.updateimage');
        Route::post('/product/images/destroy/{id}', [ProductsController::class,'destroyImage'])->name('dashboard.products.destroyimage');
        
        Route::get('/attributes', [AttributesController::class, 'list'])->name('dashboard.attributes.list');
        Route::get('/attributes/add', [AttributesController::class, 'create'])->name('dashboard.attributes.add');
        Route::post('/attributes/store', [AttributesController::class,'store'])->name('dashboard.attributes.store');
        Route::get('/attributes/edit/{id}', [AttributesController::class, 'edit'])->name('dashboard.attributes.edit');
        Route::post('/attributes/update/{id}', [AttributesController::class,'update'])->name('dashboard.attributes.update');
        Route::post('/attributes/destroy/{id}', [AttributesController::class,'destroy'])->name('dashboard.attributes.destroy');

        Route::get('/options', [OptionsController::class, 'list'])->name('dashboard.options.list');
        Route::get('/options/add', [OptionsController::class, 'create'])->name('dashboard.options.add');
        Route::post('/options/store', [OptionsController::class,'store'])->name('dashboard.options.store');
        Route::get('/options/edit/{id}', [OptionsController::class, 'edit'])->name('dashboard.options.edit');
        Route::post('/options/update/{id}', [OptionsController::class,'update'])->name('dashboard.options.update');
        Route::post('/options/destroy/{id}', [OptionsController::class,'destroy'])->name('dashboard.options.destroy');
        
        Route::get('/product/{id}/options', [ProductsController::class, 'getOptions'])->name('dashboard.products.getOptions');
        Route::post('/product/options/store', [ProductsController::class, 'updateOptions'])->name('dashboard.products.updateoptions');
    }
);