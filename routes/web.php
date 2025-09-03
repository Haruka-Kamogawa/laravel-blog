<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// middleware Auth verifies the user of your application
// If the user is not authenticated, redirect the user to the login page
// If the user is authenticated, will allow request to proceed into the app
// ログインしていないと自動的に/loginページに飛ばされる
// Route::groupの中にログインした後のページを作る(会員マイページ、記事作成フォーム、ショッピングカート、管理画面（admin dashboard etc.)
// →逆に誰でも見られるページはこれの外に書く(トップページ、商品の一覧 etc.)

Route::group(['middleware' => 'auth'], function(){
    Route::get('/', [PostController::class, 'index'])->name('index');

    // POST
    Route::group(['prefix' => 'post', 'as' => 'post.'], function(){ // 'prefix' => 'post' : URL の先頭に /post を付ける,'as' => 'post.' : ルート名の先頭に post. を付ける...name('create') 実際のルート名は post.create になる
        Route::get('/create', [PostController::class, 'create'])->name('create');

        Route::post('/store', [PostController::class, 'store'])->name('store');

        Route::get('/{id}/show', [PostController::class, 'show'])->name('show');

        Route::get('/{id}/edit', [PostController::class, 'edit'])->name('edit');

        Route::patch('/{id}/update', [PostController::class, 'update'])->name('update');

        Route::delete('/{id}/destroy', [PostController::class, 'destroy'])->name('destroy');

    });



    // COMMENT
    Route::group(['prefix' => 'comment', 'as' => 'comment.'], function(){
        Route::post('/{post_id}/store', [CommentController::class, 'store'])->name('store');

        Route::delete('/{id}/destroy', [CommentController::class, 'destroy'])->name('destroy');

        Route::patch('/{id}/update', [CommentController::class, 'update'])->name('update');
    });



    // USER
    Route::group(['prefix' => 'profile', 'as' => 'profile.'], function(){
        Route::get('/', [UserController::class, 'show'])->name('show');

        Route::get('/edit', [UserController::class, 'edit'])->name('edit');

        Route::patch('/update', [UserController::class, 'update'])->name('update');

        Route::get('/{id}/specificShow', [UserController::class, 'specificShow'])->name('specificShow');
    });

    
});