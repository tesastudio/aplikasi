<?php

use App\Http\Controllers\DeptController;
use App\Http\Controllers\GoodsController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\UserController;
use App\Livewire\Goodsreq\EditGoodsRequest;
use App\Livewire\Goodsreq\FormGoodsReq;
use App\Livewire\Goodsreq\GoodsRequest;
use App\Livewire\Goodsreq\RequestStatus;
use App\Livewire\Goodsreq\StatusGoodsRequest;
use Illuminate\Support\Facades\Route;

// Route::view('/', 'welcome');
Route::view('/','layouts.backend.blank')->middleware(['auth','verified'])->name('utama');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';

Route::get('/lte',function(){
    return view('layouts.backend.master');
});

Route::view('/blankpage','layouts.backend.blankpage');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::get('admin/dept',[DeptController::class, 'list'])->middleware(['auth'])->name('deptlist');
Route::get('admin/goods',[GoodsController::class, 'list'])->middleware(['auth'])->name('goodslist');
Route::get('admin/employee',[UserController::class, 'list'])->middleware(['auth'])->name('employeelist');

// Goods Request
Route::get('/goodsrequest',GoodsRequest::class)->middleware(['auth','verified'])->name('goodsrequest');
Route::get('/formgoodsrequest',FormGoodsReq::class)->middleware(['auth','verified'])->name('formgoodsrequest');
Route::get('/editgoodsrequest/{req_id}',EditGoodsRequest::class)->middleware('auth')->name('editgoodsrequest');
Route::get('/list_req_status',StatusGoodsRequest::class)->middleware(['auth','verified'])->name('list_req_status');
Route::get('/request_status',RequestStatus::class)->name('request_status');

// Send Email
Route::get('send-mail/{req_id}',[MailController::class,'sendEmail']);