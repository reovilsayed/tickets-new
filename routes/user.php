<?php

use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::group(
    [
        'as' => 'user.', //generalize name prefix
        'prefix' => 'user/dashboard/' //generalize url prefix
    ],
    function () {
        Route::get('/', [PageController::class, 'dashboard'])->name('dashboard');
        Route::post('/update-profile', [UserController::class, 'profileUpdate'])->name('profile.update');
        Route::get('/update-profile', [UserController::class, 'update_profile'])->name('update_profile');
        Route::get('/address-edit/{address}', [PageController::class, 'addressEdit'])->name('address-edit');
        Route::get('/address-destroy/{address}', [PageController::class, 'addressDestroy'])->name('address.destroy');

        Route::post('address-edit', [UserController::class, 'addressUpdate'])->name('address.update');
        Route::get('/track-shipping', [PageController::class, 'order_index'])->name('order_page');

        Route::get('/orders/index', [UserController::class, 'ordersIndex'])->name('ordersIndex');


        Route::get('/invoice/{order}', [UserController::class, 'invoice'])->name('invoice');
        Route::post('/order/{order}/cancel', [UserController::class, 'order_cancel'])->name('order.cancel');
        Route::get('/change_password', [UserController::class, 'change_password'])->name('change_password');
        Route::post('/update_password', [UserController::class, 'update_password'])->name('update_password');
        Route::get('/offers', [UserController::class, 'offers'])->name('offers');
        Route::get('/become/seller', [UserController::class, 'becomeSeller'])->name('become.seller');
        Route::get('remove-card',[UserController::class,'removeCard'])->name('removeCard');
        Route::get('set-card-as-default',[UserController::class,'setCardAsDefault'])->name('setCardAsDefault');
        Route::post('/feedback/store', [FeedbackController::class, 'store'])->name('feedback.store');
    }
);
