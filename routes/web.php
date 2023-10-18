<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Middleware\RedirectUnauthenticated;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/login', function () {
    if(!session("email")){
        return view('auth.login');
    }else{
        return redirect()->route('home');
    }
})->name('login');
Route::get('/', function(){
    if(!session("email")){
        return redirect()->route('login');
    }else{
        return redirect('/home');
    }
})->name('home');
Route::get('/home',  [UserController::class, 'home']);
Route::get('/search/products', [ProductController::class, 'searchH'])->name('search');
Route::get('/register', function (){
    return view('auth.register');
})->name('create-account');

//logging out
Route::get('/logout', function (){
    Session::forget('email');
    return redirect('/login');
});
Route::get('/create-user', [UserController::class, 'register'])->name('user.register');
Route::get('/connect-user', [UserController::class, 'login'])->name('user.login');

// Categories routes
Route::get('/categories', [CategoryController::class, 'index'])->name('category.index')->middleware(RedirectUnauthenticated::class);
Route::get('/sc/categories', [CategoryController::class, 'search'])->name('search.category');
Route::get('/add-cat',function(){
    return view('categories.create');
})->name('add.category')->middleware(RedirectUnauthenticated::class);
Route::post('/save/cat', [CategoryController::class, 'create'])->name('save.category')->middleware(RedirectUnauthenticated::class);
Route::get('/dlt/cat/{id}', [CategoryController::class, 'delete'])->name('delete.category')->middleware(RedirectUnauthenticated::class);
Route::get('/edit/cat/{id}', [CategoryController::class, 'edit'])->name('edit.category')->middleware(RedirectUnauthenticated::class);
Route::put('/update/cat/{category}', [CategoryController::class, 'update'])->name('update.category')->middleware(RedirectUnauthenticated::class);

// Prolducts routes
Route::get('/products', [ProductController::class, 'index'])->name('product.index')->middleware(RedirectUnauthenticated::class);
Route::get('/sc/products', [ProductController::class, 'search'])->name('search.product');
Route::get('/add-prod',[ProductController::class, 'create'])->name('add.product')->middleware(RedirectUnauthenticated::class);
Route::post('/save/prod', [ProductController::class, 'store'])->name('save.product')->middleware(RedirectUnauthenticated::class);
Route::get('/dlt/prod/{id}', [ProductController::class, 'delete'])->name('delete.product')->middleware(RedirectUnauthenticated::class);
Route::get('/edit/prod/{id}', [ProductController::class, 'edit'])->name('edit.product')->middleware(RedirectUnauthenticated::class);
Route::put('/update/prod/{product}', [ProductController::class, 'update'])->name('update.product')->middleware(RedirectUnauthenticated::class);
