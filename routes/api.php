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
use App\Http\Controllers\HoaDonNhapKhoController;
use App\Http\Controllers\KhachHangController;
use App\Http\Controllers\LogControlter;
use App\Http\Controllers\LuongController;
use App\Http\Controllers\MaGiamGiaController;
use App\Http\Controllers\NhapKhoController;
use App\Http\Controllers\ReViewMonAnController;
use App\Http\Controllers\ThanhToanController;
use App\Http\Controllers\ThongKecontroller;
use App\Http\Controllers\TonKhoNguyenLieuController;
use App\Http\Controllers\TransactionController;
use App\Models\HoaDonBanHang;
use App\Models\Luong;
use Illuminate\Support\Facades\Route;
Route::post('khach-hang/login',[KhachHangController::class,'login']);
Route::post('login', [AuthController::class, 'login']);
Route::post('upload', [FileController::class, 'uploadFile']);
Route::get('get-upload', [FileController::class, 'getData']);
Route::post('/transactions', [ThanhToanController::class, 'store']);
Route::get('/historyviettelpay', [ThanhToanController::class, 'fetchHistory']);
Route::get('/get-data-mon-an/{token}', [MonAnController::class, 'getDataMonAnToken']);
Route::post('/them-mon-an', [DichVuController::class, 'themMonAn']);
Route::post('/forgot-password', [AdminController::class, 'forgotPasswordAdmin']);
Route::post('/update-password', [AdminController::class, 'updatePasswordAdmin']);
Route::get('/get-mon-an-pho-bien', [MonAnController::class, 'getMonAnPhoBien']);

Route::group(['prefix' => '/admin'], function () {
    Route::get('/export', [AdminController::class, 'export']);
    Route::get('/get-user', [AuthController::class, 'getUser']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/create', [AdminController::class, 'createAdmin']);
    Route::get('/get-data', [AdminController::class, 'getDataAdmin']);
    Route::post('/search', [AdminController::class, 'searchAdmin']);
    Route::post('/change-password', [AdminController::class, 'changePasswordAdmin']);
    Route::post('/update-user', [AdminController::class, 'updateAdmin']);
    Route::post('/delete-user', [AdminController::class, 'deleteAdmin']);
    Route::post('/change-status', [AdminController::class, 'changeStatus']);
    // Route::post('/update', [AdminController::class, 'updateAdmin']);
    Route::get('/create-token/{id_ban}', [AuthController::class, 'generateQRCode']);
    Route::post('/get-qrcode', [AuthController::class, 'getQRCode']);
    Route::post('/change-status-hoa-don', [HoaDonBanHangController::class, 'changeStatus']);

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
        Route::post('/tim-danh-muc', [DanhMucController::class, 'searchDanhMuc']);

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
        Route::post('/tim-mon', [MonAnController::class, 'searchMonAn']);
    });

    Route::group(['prefix' => '/ban'], function () {
        Route::post('/create', [BanController::class, 'createBan']);
        Route::get('/get-data', [BanController::class, 'getDataBan']);
        Route::post('/change-status', [BanController::class, 'changeStatus']);
        Route::post('/update', [BanController::class, 'updateBan']);
        Route::post('/delete', [BanController::class, 'deleteBan']);
        Route::post('/tim-ban', [BanController::class, 'searchBan']);
        Route::post('/mon-an-theo-ban', [BanController::class, 'getMonAnTheoBan']);
        Route::post('/gop-ban', [BanController::class, 'gopBan']);


    });
    Route::group(['prefix'  =>  '/nha-cung-cap'], function () {
        // Lấy dữ liệu  -> get
        Route::get('/get-data', [NhaCungCapController::class, 'getData']);
        Route::post('/tim-nha-cung-cap', [NhaCungCapController::class, 'searchNhaCungCap']);
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
        Route::post('/tim-chuyen-muc-bai-viet', [ChuyenMucBaiVietController::class, 'searchChuyenMucBaiViet']);
    });
    Route::group(['prefix'  =>  '/bai-viet'], function () {

        Route::get('/get-data', [BaiViet1Controller::class, 'getData']);
        Route::post('/tim-bai-viet', [BaiViet1Controller::class, 'timBaiViet']);
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
        Route::post('/dong-ban', [DichVuController::class, 'DongBan']);


    });
    Route::group(['prefix'  =>  '/nguyen-lieu'], function () {
        Route::post('/tao-nguyen-lieu', [NguyenLieuController::class, 'themNguyenLieu']);
        Route::get('/get-nguyen-lieu', [NguyenLieuController::class, 'getNguyenLieu']);
        Route::post('/cap-nhat-nguyen-lieu', [NguyenLieuController::class, 'capnhatNguyenLieu']);
        Route::post('/doi-trang-thai', [NguyenLieuController::class, 'doiTrangThai']);
        Route::post('/xoa-nguyen-lieu', [NguyenLieuController::class, 'deleteNguyenLieu']);
        Route::post('/tim-nguyen-lieu', [NguyenLieuController::class, 'searchNguyenLieu']);

    });
    Route::group(['prefix'  =>  '/hoa-don'], function () {
        Route::post('/data-bill', [HoaDonBanHangController::class, 'dataBill']);
        Route::post('/hoa-don', [HoaDonBanHangController::class, 'hoaDon']);
        Route::post('/chi-tiet-hoa-don', [HoaDonBanHangController::class, 'chitietHoaDon']);
        Route::get('/export', [HoaDonBanHangController::class, 'export']);



    });
    Route::group(['prefix'  =>  '/log'], function () {
        Route::get('/lich-su-thanh-toan', [LogControlter::class, 'dataHistoryBuill']);
    });
    Route::group(['prefix'  =>  '/khach-hang'], function () {
        Route::post('/store', [KhachHangController::class, 'store']);
        Route::post('/update', [KhachHangController::class, 'updateKh']);
        Route::post('/delete', [KhachHangController::class, 'deleteKh']);
        Route::get('/get-data', [KhachHangController::class, 'getData']);
        Route::get('/export', [KhachHangController::class, 'export']);
        Route::post('/search-khach-hang', [KhachHangController::class, 'searchKhachHang']);

    });
    Route::group(['prefix'  =>  '/tinh-luong'], function () {
        Route::post('/store', [LuongController::class, 'store']);
        Route::post('/update-rose', [LuongController::class, 'updateRose']);
        Route::post('/update-receive', [LuongController::class, 'updateReceive']);
        Route::post('/detal', [LuongController::class, 'Detal']);
    });
    Route::group(['prefix'  =>  '/nhap-kho'], function () {
        Route::get('/lay-du-lieu', [HoaDonNhapKhoController::class, 'getdata']);
        Route::post('/them-nguyen-lieu', [HoaDonNhapKhoController::class, 'addNguyenLieu']);
        Route::post('/cap-nhat-nhap-kho', [HoaDonNhapKhoController::class, 'updateNhapKho']);
        Route::post('/xoa-nhap-kho/{id}', [HoaDonNhapKhoController::class, 'xoaNguyenLieu']);
        Route::post('/tao-hoa-don-nhap-kho', [HoaDonNhapKhoController::class, 'createHoaDonNhapKho']);
        Route::post('/data-hoa-don-nhap-kho', [HoaDonNhapKhoController::class, 'getDataHoaDonNhapKho']);
        Route::post('/data-chi-tiet-hoa-don-nhap-kho', [HoaDonNhapKhoController::class, 'getDataChiTietHoaDonNhapKho']);
        Route::post('/export', [HoaDonNhapKhoController::class, 'export']);

    });
    Route::group(['prefix'  =>  '/ton-kho'], function () {
        Route::get('/get-data', [TonKhoNguyenLieuController::class, 'getdataTonKho']);
        Route::post('/update-ton-kho', [TonKhoNguyenLieuController::class, 'updateTonKho']);
    });
    Route::group(['prefix'  =>  '/ma-giam-gia'], function () {
        Route::post('/tao-ma-giam-gia', [MaGiamGiaController::class, 'createMaGiamGia']);
        Route::get('/lay-du-lieu', [MaGiamGiaController::class, 'getdulieu']);
        Route::post('/doi-trang-thai', [MaGiamGiaController::class, 'changesMaGiamGia']);
        Route::post('/update-ma-giam-gia', [MaGiamGiaController::class, 'updateMaGiamGia']);
        Route::post('/xoa-ma-giam-gia', [MaGiamGiaController::class, 'deleteMaGiamGia']);

    });
    Route::group(['prefix'  =>  '/thong-ke'], function () {
        Route::post('data-thong-ke-1',[ThongKecontroller::class,'getDataThongKe1']);
        Route::post('/doanh-thu', [ThongKecontroller::class, 'tinhDoanhThu']);
    });
});

Route::group(['prefix'  =>  '/khach-hang'], function () {
    Route::post('send-mail-otp',[KhachHangController::class,'sendMailOtp']);
    Route::get('logout', [KhachHangController::class, 'logout']);
    Route::group(['prefix'  =>  '/khach-hang'], function () {
        Route::post('/get-mon-id', [MonAnController::class, 'getMonTheoID']);
        Route::get('/get-mon-an-pho-bien', [MonAnController::class, 'getMonAnPhoBien']);
        Route::post('/tim-mon', [MonAnController::class, 'searchMonAn']);
    });
    Route::group(['prefix'  =>  '/review'], function () {
        Route::get('/{id_mon_an}', [ReViewMonAnController::class, 'getData']);
        Route::post('/tao-danh-gia', [ReViewMonAnController::class, 'createReView']);
        Route::post('/xoa-danh-gia', [ReViewMonAnController::class, 'deleteReview']);
    });
});
