<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\MonAnController;
use App\Http\Controllers\QuyenController;
use App\Models\MonAn;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::group(['prefix' => '/admin'], function () {

    Route::post('/create', [AdminController::class, 'createAdmin']);
    Route::get('/get-data', [AdminController::class, 'getDataAdmin']);
    Route::post('/search', [AdminController::class, 'searchAdmin']);
    Route::post('/change-status', [AdminController::class, 'changeStatus']);
    Route::post('/update', [AdminController::class, 'updateAdmin']);

    Route::group(['prefix' => '/quyen'], function () {
        Route::post('/create', [QuyenController::class, 'createQuyen']);
        Route::get('/get-data', [QuyenController::class, 'getDataQuyen']);
        Route::post('/change-status', [QuyenController::class, 'changeStatus']);
        Route::post('/update', [QuyenController::class, 'updateQuyen']);
        Route::post('/delete', [QuyenController::class, 'deleteQuyen']);

    });

    Route::group(['prefix' => '/danh-muc'], function () {

    });
    Route::group(['prefix' => '/mon-an'], function () {
        Route::post('/create', [MonAnController::class, 'createMonAn']);
        Route::get('/get-data', [MonAnController::class, 'getDataMonAn']);
        Route::post('/change-status', [MonAnController::class, 'changeStatus']);
        Route::post('/update', [MonAnController::class, 'updateMonAn']);
        Route::post('/delete', [MonAnController::class, 'deleteMonAn']);

    });
});
