<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\WelcomeController;
use App\Models\Category;
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
Route::get('locale/{locale}', function ($locale) {
    \Session::put('locale', $locale);
    return redirect()->back();
});

View::composer('layouts.front.inc.header', function($view){
    $categories=Category::where('parent',0)->get();
    $view->with('menu_categories',$categories);
});

Route::get('/',[WelcomeController::class,'index']);

Route::resource('article',ArticleController::class)->middleware(['auth','verified']);
Route::get('/article/detail/{id}/{slug}',[ArticleController::class,'show'])->name('article.show');


Auth::routes(['verify'=>true]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
