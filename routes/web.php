<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


/**
 * 블로그 Post
 */
// 사이트 데쉬보드
Route::get('/blog/create', [
    \Jiny\Site\Http\Controllers\SitePostController::class,
    "index"])->middleware(['web']);

Route::get('/blog/list', [
        \Jiny\Site\Http\Controllers\SitePostController::class,
        "list"])->middleware(['web']);

Route::get('/blog/{id}', [
            \Jiny\Site\Http\Controllers\SitePostController::class,
            "view"])
            ->where('id', '[0-9]+')
            ->middleware(['web']);
