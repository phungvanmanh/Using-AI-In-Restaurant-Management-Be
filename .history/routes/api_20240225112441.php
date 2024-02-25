<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\DanhMucController;
use App\Http\Controllers\QuyenController;
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
        Route::post('/create', [DanhMucController::class, 'createDanhMuc']);
        Route::get('/get-data', [DanhMucController::class, 'getDataDanhMuc']);
        Route::post('/change-status', [DanhMucController::class, 'changeStatus']);
        Route::post('/update', [DanhMucController::class, 'updateDanhMuc']);
        Route::post('/delete', [DanhMucController::class, 'deleteDanhMuc']);
    });

    Route::group(['prefix' => '/khu-vuc'], function () {
        Route::post('/create', [DanhMucController::class, 'createDanhMuc']);
        Route::get('/get-data', [DanhMucController::class, 'getDataDanhMuc']);
        Route::post('/change-status', [DanhMucController::class, 'changeStatus']);
        Route::post('/update', [DanhMucController::class, 'updateDanhMuc']);
        Route::post('/delete', [DanhMucController::class, 'deleteDanhMuc']);
    });
});
