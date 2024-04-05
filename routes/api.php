<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BanController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\DanhMucController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\KhuVucController;
use App\Http\Controllers\LichLamViecController;
use App\Http\Controllers\MonAnController;
use App\Http\Controllers\QuyenController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
Route::post('login', [AuthController::class, 'login']);
Route::post('upload', [FileController::class, 'uploadFile']);
Route::get('get-upload', [FileController::class, 'getData']);

Route::group(['prefix' => '/admin'], function () {
    Route::get('get-user', [AuthController::class, 'getUser']);
    Route::post('logout', [AuthController::class, 'logout']);
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

    Route::group(['prefix' => '/lich-lam-viec'], function () {
        Route::get('/get-days/{type}', [Controller::class, 'getDays']);
        Route::post('/dang-ky/store', [LichLamViecController::class, 'createLichLamViec']);
        Route::post('/dang-ky/update', [LichLamViecController::class, 'updateLichLamViec']);
        // Route::get('/get-data', [BanController::class, 'getDataBan']);
        // Route::post('/change-status', [BanController::class, 'changeStatus']);
        // Route::post('/update', [BanController::class, 'updateBan']);
        // Route::post('/delete', [BanController::class, 'deleteBan']);
    });

    Route::group(['prefix' => '/danh-muc'], function () {
        Route::post('/create', [DanhMucController::class, 'createDanhMuc']);
        Route::get('/get-data', [DanhMucController::class, 'getDataDanhMuc']);
        Route::post('/change-status', [DanhMucController::class, 'changeStatus']);
        Route::post('/update', [DanhMucController::class, 'updateDanhMuc']);
        Route::post('/delete', [DanhMucController::class, 'deleteDanhMuc']);
    });

    Route::group(['prefix' => '/khu-vuc'], function () {
        Route::post('/create', [KhuVucController::class, 'createKhuVuc']);
        Route::get('/get-data', [KhuVucController::class, 'getDataKhuVuc']);
        Route::post('/change-status', [KhuVucController::class, 'changeStatus']);
        Route::post('/update', [KhuVucController::class, 'updateKhuVuc']);
        Route::post('/delete', [KhuVucController::class, 'deleteKhuVuc']);
    });

    Route::group(['prefix' => '/mon-an'], function () {
        Route::post('/create', [MonAnController::class, 'createMonAn']);
        Route::get('/get-data', [MonAnController::class, 'getDataMonAn']);
        Route::post('/change-status', [MonAnController::class, 'changeStatus']);
        Route::post('/update', [MonAnController::class, 'updateMonAn']);
        Route::post('/delete', [MonAnController::class, 'deleteMonAn']);
    });

    Route::group(['prefix' => '/ban'], function () {
        Route::post('/create', [BanController::class, 'createBan']);
        Route::get('/get-data', [BanController::class, 'getDataBan']);
        Route::post('/change-status', [BanController::class, 'changeStatus']);
        Route::post('/update', [BanController::class, 'updateBan']);
        Route::post('/delete', [BanController::class, 'deleteBan']);
    });
});

