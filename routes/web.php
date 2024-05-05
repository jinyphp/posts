<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * 블로그 Post
 */

 Route::middleware(['web'])
 ->name('blog')
 ->prefix("/blog")->group(function () {
    Route::get('/', [
        \Jiny\Posts\Http\Controllers\SitePostController::class,
        "index"])->middleware(['web']);

    Route::get('/{id}', [
        \Jiny\Posts\Http\Controllers\SitePostController::class,
        "view"])
        ->where('id', '[0-9]+')
        ->middleware(['web']);
 });

 /*
// 사이트 데쉬보드
Route::get('/blog/create', [
    \Jiny\Posts\Http\Controllers\SitePostController::class,
    "index"])->middleware(['web']);




            */
