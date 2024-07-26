<?php

use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\MassageController;
use App\Http\Controllers\ProductVariationController;
use App\Http\Controllers\Seller\HomeController;
use App\Http\Controllers\Seller\ProductController;
use App\Http\Controllers\Seller\SellerPagesController;
use App\Http\Controllers\TicketsController;
use App\Models\Product;
use Illuminate\Support\Facades\Route;
use Laravel\Cashier\Invoice;

Route::group(
    [
        'as' => 'vendor.', //generalize name prefix
        'prefix' => 'vendor/dashboard' //generalize url prefix
    ],
    function () {
        Route::get('/', [SellerPagesController::class, 'dashboard'])->name('dashboard');

        Route::get('/product/create', [ProductController::class, 'create'])->name('create.product');

        Route::post('/product/store', [ProductController::class, 'store'])->name('product.store');
        Route::post('/product/update/{product}', [ProductController::class, 'update'])->name('product.update');

        Route::get('/products', [ProductController::class, 'products'])->name('products');
        Route::get('/product-edit/{slug}', [ProductController::class, 'productEdit'])->name('product.edit');
        Route::post('/products-delete{product}', [ProductController::class, 'productRemove'])->name('products.delete');

        Route::get('/orders/index', [SellerPagesController::class, 'ordersIndex'])->name('ordersIndex');
        Route::get('/order/view/{ordernumber}', [SellerPagesController::class, 'orderView'])->name('orderView');
        Route::post('/shipping', [SellerPagesController::class, 'shippingUrl'])->name('order.shipping');
        Route::get('/invoice/{order}', [SellerPagesController::class, 'invoice'])->name('invoice');


        Route::post('/ChangePassword', [SellerPagesController::class, 'ChangePassword'])->name('ChangePassword');

        Route::get('/banner', [SellerPagesController::class, 'banner'])->name('banner');
        Route::post('/banner/store', [SellerPagesController::class, 'bannerStore'])->name('banner.store');
        Route::get('/shop/policy', [SellerPagesController::class, 'shopPolicy'])->name('shopPolicy');
        Route::post('/shop/policy/store', [SellerPagesController::class, 'shopPolicyStore'])->name('shopPolicy.store');

        Route::post('/shop/shopMenu/store', [SellerPagesController::class, 'shopMenuStore'])->name('shopMenuStore.store');

        // Route::get('/offers', [SellerPagesController::class, 'offers'])->name('offers');
        // Route::get('/offer-accept/{offer}', [SellerPagesController::class, 'offerAccept'])->name('offer.accept');
        // Route::get('/offer-decline/{offer}', [SellerPagesController::class, 'offerDecline'])->name('offer.decline');
        Route::get('vendor/dashboard/order/action/{order}', [SellerPagesController::class, 'orderDeliver'])->name('order.action');
        Route::get('vendor/dashboard/order/cancel/{order}', [SellerPagesController::class, 'orderCancel'])->name('order.cancel');
        Route::get('vendor/dashboard/order/approve/{order}', [SellerPagesController::class, 'orderApprove'])->name('order.approve');



        Route::get('ticket/create', [TicketsController::class, 'create'])->name('ticket.create');
        Route::get('tickets', [TicketsController::class, 'index'])->name('ticket.index');

        Route::post('ticket/store', [TicketsController::class, 'store'])->name('ticket.store');

        // Route::get('/charges', [SellerPagesController::class, 'charges'])->name('charges');
        // Route::get('/charge/{charge}', [SellerPagesController::class, 'charge'])->name('charge');

        // Route::get('/massage/{id?}', [MassageController::class, 'shopMassage'])->name('massage');
        // Route::get('/massage/store/{id?}', [MassageController::class, 'shopMassagestore'])->name('massage.store')->middleware('auth');

        // Route::get('vendor/dashboard/setting/cancelSubscription', [SellerPagesController::class, 'cancelSubscription'])->name('cancelSubscription');
        // Route::get('vendor/dashboard/setting/resumeSubscription', [SellerPagesController::class, 'resumeSubscription'])->name('resumeSubscription');
        // Route::get('vendor/dashboard/setting/cancelSubscriptionNow', [SellerPagesController::class, 'cancelSubscriptionNow'])->name('cancelSubscriptionNow');
        // Route::get('/feedbacks', [FeedbackController::class, 'vendorFeedbacks'])->name('feedbacks');

        Route::post('store-attribute', [ProductVariationController::class, 'storeAttribue'])->name('store.attribute');
        Route::post('update-attribute', [ProductVariationController::class, 'updateAttribue'])->name('update.attribute');
        Route::get('new-variation/{product}', [ProductVariationController::class, 'newVariation'])->name('new.variation');
        Route::post('update-variation/{product}', [ProductVariationController::class, 'updateVariation'])->name('update.variation');
        Route::get('delete-meta/{product}', [ProductVariationController::class, 'deleteProductMeta'])->name('delete.product.meta');
        Route::get('delete-attribute/{attribute}', [ProductVariationController::class, 'deleteProductAttribute'])->name('delete.product.attribute');
        Route::get('copy-product/{product}', [ProductVariationController::class, 'CopyProduct'])->name('copy.product');
        Route::get('create-all-variation-from-attribute/{product}', [ProductVariationController::class, 'create_all_variation'])->name('create.all.variation');
        Route::get('delete-all-child/{product}', [ProductVariationController::class, 'delete_all_child'])->name('delete.all.child');
        Route::post('ticket-check', [HomeController::class, 'ticketCheck'])->name('ticket.check');
        Route::get('ticket-update/{order}', [HomeController::class, 'ticketUpdate'])->name('ticket.update');
    }
);
