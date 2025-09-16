<?php

use App\Http\Controllers\SmsController;
use Illuminate\Support\Facades\Route;

use function Termwind\render;

//Route::get('/', function () {
//return 1;
//    return redirect('login');
//});


Route::get('/validate/{secret_key}', [SmsController::class, 'validation']);

Route::get('/', [SmsController::class, 'login'])->name('login');

Route::post('/', [SmsController::class, 'login'])->name('login');

Route::get('/dashboard', [SmsController::class, 'dashboard'])->name('dashboard');

Route::post('/addbalance', [SmsController::class, 'addBalance'])->name('balance.add');

Route::post('/createsms',[SmsController::class, 'smsCreate'])->name('sms.create');

Route::get('/admin', [SmsController::class, 'admin'])->name('admin');

Route::get('/admin/{id}', [SmsController::class, 'userdashboard'])->name('admin.userdashboard');

Route::post('/logout',[SmsController::class, 'logout'])->name('logout');