<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\c_booking;
use App\Http\Controllers\C_Klien;
use App\Http\Controllers\c_date;
use App\Http\Controllers\c_event;
use App\Http\Controllers\c_package;
use App\Http\Controllers\c_vendor;
use App\Http\Controllers\c_vendorservice;
use App\Http\Controllers\c_vendor_profile;
use App\Http\Controllers\c_pengguna;
use App\Http\Controllers\c_invoice;
use App\Http\Controllers\c_profile_klien;

/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
*/
Route::get('login', [AuthController::class, 'showLogin'])->name('login');
Route::post('login', [AuthController::class, 'login']);
Route::get('register', [AuthController::class, 'showRegister'])->name('register');
Route::post('register', [AuthController::class, 'register']);
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Landing Page (Klien)
|--------------------------------------------------------------------------
*/
Route::get('/home', [LandingController::class, 'index'])->name('klien');

/*
|--------------------------------------------------------------------------
| Dashboard Admin & Vendor & Klien
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/dashboard-admin', function () {
        return view('admin.v_dashboard-admin');
    })->name('admin.dashboard');  // ubah namanya jadi admin.dashboard

    Route::get('/dashboard-vendor', function () {
        return view('vendor.v_dashboard-vendor');
    })->name('vendor.dashboard');

    Route::get('/dashboard-klien', function () {
        return view('klien.v_dashboard-klien');
    })->name('klien.dashboard');
});






/*
|--------------------------------------------------------------------------
| Fitur yang ada di klien
|--------------------------------------------------------------------------
*/
Route::prefix('klien')->middleware('auth')->group(function () {

     // ==========Profile klien ==========
    Route::get('profile', [c_profile_klien::class, 'index'])->name('klien.profile');
    Route::get('profile/edit', [c_profile_klien::class, 'edit'])->name('klien.profile.edit');
    Route::put('profile/update', [c_profile_klien::class, 'update'])->name('klien.profile.update');


 // ========== Booking Klien ==========
    Route::get('/booking', [c_booking::class, 'index'])->name('klien.booking.index');
    Route::get('/booking/create/{package}', [c_booking::class, 'create'])->name('klien.booking.create');
    Route::post('/booking', [c_booking::class, 'store'])->name('klien.booking.store');
    Route::get('/booking/list', [c_booking::class, 'list'])->name('klien.booking.list');
 


});







/*
|--------------------------------------------------------------------------
| Kelola Yang ada di ADMIN
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->middleware('auth')->group(function () {

 // ========== Kelola Tanggal ==========
    Route::get('dates', [c_date::class, 'index'])->name('admin.dates.index');
    Route::post('dates/update-status', [c_date::class, 'updateStatus'])->name('admin.dates.updateStatus');


 // ========== Kelola Paket ==========
     Route::get('/package', [c_package::class, 'index'])->name('admin.package.index');
    Route::get('/package/create', [c_package::class, 'create'])->name('admin.package.create');
    Route::post('/package', [c_package::class, 'store'])->name('admin.package.store');
    Route::get('/package/{id}', [c_package::class, 'show'])->name('admin.package.show');
    Route::get('/package/{id}/edit', [c_package::class, 'edit'])->name('admin.package.edit');
    Route::put('/package/{id}', [c_package::class, 'update'])->name('admin.package.update');
    Route::delete('/package/{id}', [c_package::class, 'destroy'])->name('admin.package.destroy');



 // ========== Kelola Kegiatan ==========
    Route::get('event', [c_event::class, 'index'])->name('admin.event.index');
    Route::get('event/create', [c_event::class, 'create'])->name('admin.event.create');
    Route::post('event/store', [c_event::class, 'store'])->name('admin.event.store');
    Route::get('event/edit/{id}', [c_event::class, 'edit'])->name('admin.event.edit');
    Route::post('event/update/{id}', [c_event::class, 'update'])->name('admin.event.update');
    Route::get('event/detail/{id}', [c_event::class, 'show'])->name('admin.event.show');
    Route::delete('event/delete/{id}', [c_event::class, 'destroy'])->name('admin.event.destroy');

    // Penugasan Tim (bagian dari event, tapi ditulis eksplisit biar jelas)
    Route::post('event/assign-task', [c_event::class, 'assignTask'])->name('admin.event.assignTask');
    Route::post('event/remove-task', [c_event::class, 'removeTask'])->name('admin.event.removeTask');


    // ========== Kelola Vendor ==========
    Route::get('vendor', [c_vendor::class, 'index'])->name('admin.vendor.index');
    Route::get('vendor/detail/{id}', [c_vendor::class, 'show'])->name('admin.vendor.show');
    Route::delete('vendor/delete/{id}', [c_vendor::class, 'destroy'])->name('admin.vendor.destroy');
    Route::put('vendor/status/{id}', [c_vendor::class, 'toggleStatus'])->name('admin.vendor.toggleStatus');

    // ========== Kelola Pengguna ==========
    Route::get('pengguna', [c_pengguna::class, 'index'])->name('admin.pengguna.index');
    Route::get('pengguna/create', [c_pengguna::class, 'create'])->name('admin.pengguna.create');
    Route::post('pengguna/store', [c_pengguna::class, 'store'])->name('admin.pengguna.store');
    Route::get('pengguna/{id}/edit', [c_pengguna::class, 'edit'])->name('admin.pengguna.edit');
    Route::post('pengguna/{id}/update', [c_pengguna::class, 'update'])->name('admin.pengguna.update');
    Route::get('pengguna/{id}/delete', [c_pengguna::class, 'delete'])->name('admin.pengguna.delete');

    
    // ========== Kelola Invoice ==========
    Route::get('invoice', [c_invoice::class, 'index'])->name('admin.invoice.index');
    Route::get('invoice/create', [c_invoice::class, 'create'])->name('admin.invoice.create');
    Route::post('invoice/store', [c_invoice::class, 'store'])->name('admin.invoice.store');
    Route::get('/invoice/pdf/{id}', [c_invoice::class, 'print'])->name('admin.invoice.pdf');
    Route::get('/invoice/print/{id}', [c_invoice::class, 'print'])->name('admin.invoice.print');
    Route::delete('invoice/{id}', [c_invoice::class, 'destroy'])->name('admin.invoice.destroy');








});







/*
|--------------------------------------------------------------------------
| Kelola Yang ada di VENDOR
|--------------------------------------------------------------------------
*/

Route::prefix('vendor')->middleware('auth')->group(function () {

    // ========== Kelola Jasa & produk ==========
    Route::get('vendorservice', [c_vendorservice::class, 'index'])->name('vendor.service.index');
    Route::get('vendorservice/create', [c_vendorservice::class, 'create'])->name('vendor.service.create');
    Route::post('vendorservice/store', [c_vendorservice::class, 'store'])->name('vendor.service.store');
    Route::get('vendorservice/detail/{id}', [c_vendorservice::class, 'show'])->name('vendor.service.show');
    Route::get('vendorservice/edit/{id}', [c_vendorservice::class, 'edit'])->name('vendor.service.edit');
    Route::put('vendorservice/update/{id}', [c_vendorservice::class, 'update'])->name('vendor.service.update');
    Route::delete('vendorservice/delete/{id}', [c_vendorservice::class, 'destroy'])->name('vendor.service.destroy');

     // ========== Profile Vendor ==========
    Route::get('profile', [c_vendor_profile::class, 'index'])->name('vendor.profile.index');
    Route::get('profile/create', [c_vendor_profile::class, 'create'])->name('vendor.profile.create');
    Route::post('profile/store', [c_vendor_profile::class, 'store'])->name('vendor.profile.store');
    Route::get('profile/edit', [c_vendor_profile::class, 'edit'])->name('vendor.profile.edit');
    Route::put('profile/update', [c_vendor_profile::class, 'update'])->name('vendor.profile.update');
});





