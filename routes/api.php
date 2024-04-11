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
use App\Http\Controllers\BaiViet1Controller;
use App\Http\Controllers\ChuyenMucBaiVietController;
use App\Http\Controllers\NhaCungCapController;
use App\Http\Controllers\DichVuController;
use App\Http\Controllers\NguyenLieuController;
use App\Http\Controllers\HoaDonBanHangController;
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
    Route::get('/create-token/{id_ban}', [AuthController::class, 'generateQRCode']);
    Route::post('/get-qrcode', [AuthController::class, 'getQRCode']);

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
    Route::group(['prefix'  =>  '/nha-cung-cap'], function () {
        // Lấy dữ liệu  -> get
        Route::get('/get-data', [NhaCungCapController::class, 'getData']);
        // Route::post('/tim-nha-cung-cap', [NhaCungCapController::class, 'searchNhaCungCap']);
        Route::post('/create', [NhaCungCapController::class, 'createNhaCungCap']);
        Route::post('/delete', [NhaCungCapController::class, 'xoaNhaCungCap']);
        Route::post('/update', [NhaCungCapController::class, 'capNhatNhaCungCap']);
        Route::post('/change-status', [NhaCungCapController::class, 'doiTrangThaiNhaCungCap']);
    });
    Route::group(['prefix'  =>  '/chuyen-muc-bai-viet'], function () {
        Route::get('/get-data', [ChuyenMucBaiVietController::class, 'getData']);
        // Route::post('/tim-chuyen-muc', [ChuyenMucBaiVietController::class, 'searchChuyenMuc']);
        Route::post('/create', [ChuyenMucBaiVietController::class, 'createChuyenMuc']);
        Route::post('/delete', [ChuyenMucBaiVietController::class, 'deleteChuyenMuc']);
        Route::post('/update', [ChuyenMucBaiVietController::class, 'capNhatChuyenMuc']);
        Route::post('/status', [ChuyenMucBaiVietController::class, 'doiTrangThaiChuyenMuc']);
    });
    Route::group(['prefix'  =>  '/bai-viet'], function () {

        Route::get('/get-data', [BaiViet1Controller::class, 'getData']);
        // Route::post('/tim-tin-tuc', [BaiVietController::class, 'searchTinTuc']);
        Route::post('/tao-bai-viet', [BaiViet1Controller::class, 'createBaiViet1']);
        Route::post('/delete', [BaiViet1Controller::class, 'xoaBaiViet']);
        Route::post('/update', [BaiViet1Controller::class, 'capNhatBaiViet']);
        // Route::put('/doi-trang-thai', [BaiVietController::class, 'doiTrangThaiTinTuc']);
    });
    Route::group(['prefix'  =>  '/su-dung-dich-vu'], function () {

        Route::post('/lay-du-lieu-theo-khu', [DichVuController::class, 'getdataTheoKhuVuc']);
        Route::post('/tao-hoa-don', [DichVuController::class, 'createHoaDon']);
        Route::post('/get-id-hoa-don', [DichVuController::class, 'getIdHoaDon']);
        Route::post('/them-mon-an', [DichVuController::class, 'themMonAn']);
        Route::post('/get-chi-tiet', [DichVuController::class, 'getChiTietBanHang']);
        Route::post('/update-chi-tiet-ban-hang', [DichVuController::class, 'updateChiTietBanHang']);
        Route::post('/xoa-chi-tiet', [DichVuController::class, 'xoaChiTietBanHang']);
        Route::post('/update-hoa-don-ban-hang', [DichVuController::class, 'updateHoaDonBanHang']);

    });
    Route::group(['prefix'  =>  '/nguyen-lieu'], function () {
        Route::post('/tao-nguyen-lieu', [NguyenLieuController::class, 'themNguyenLieu']);
        Route::get('/get-nguyen-lieu', [NguyenLieuController::class, 'getNguyenLieu']);
        Route::post('/cap-nhat-nguyen-lieu', [NguyenLieuController::class, 'capnhatNguyenLieu']);
        Route::post('/doi-trang-thai', [NguyenLieuController::class, 'doiTrangThai']);
        Route::post('/xoa-nguyen-lieu', [NguyenLieuController::class, 'deleteNguyenLieu']);

    });
    Route::group(['prefix'  =>  '/hoa-don'], function () {
        Route::post('/data-bill', [HoaDonBanHangController::class, 'dataBill']);
        Route::post('/hoa-don', [HoaDonBanHangController::class, 'hoaDon']);


    });
});

