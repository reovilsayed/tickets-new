<?php

use App\Http\Controllers\{AdminCustomController, EventAnalyticsController, ExportController, MassInviteController, PosUserReport};
use App\Exports\CustomerExport;
use App\Models\Invite;
use App\Models\Order;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Maatwebsite\Excel\Facades\Excel;

use TCG\Voyager\Facades\Voyager;

Route::group(['prefix' => 'admin', 'middleware' => 'admin.user'], function () {

    Route::get('/pos/{order}/mark', function (Order $order) {

        $order->update([
            'alert' => 'resolved'
        ]);
        return redirect()->back()->with('sucess', 'Order marked');
    })->name('admin.order.marked');
    Voyager::routes();
    Route::get('customer/export', function () {
        $users = User::all()->map(fn($user) => [
            'first_name' => $user->name,
            'last_name' => $user->l_name,
            'email' => $user->email,
            'contactNumber' => $user->contact_number,
            'vatNumber' => $user->vatNumber,
            'events' => $user->events->unique()->pluck('name')->implode(', '),
        ]);

        return Excel::download(new CustomerExport($users), 'customer_' . now()->format('dmyhi') . '.xlsx');
    })->name('voyager.customer.export');

    Route::get('/products/{product}/duplicate', [AdminCustomController::class, 'duplicateProduct'])->name('voyager.products.duplicate');
    Route::get('/users/{user}/staff', function (User $user) {
        $logs = $user->scans->groupBy('ticket')->map(function ($ticket) {
            return $ticket->map(fn($data) => ['log' => $data->pivot->action . ' at ' . $data->created_at->format('Y-m-d')]);
        });

        // $products = $user->scans->groupBy(function ($ticket) {
        //     return $ticket->product->name;
        // })->map(fn($products) => $products->count())->toArray();

        // $zones = $user->zones->groupBy(function ($zone) {
        //     return $zone->name;
        // })->map(fn($products) => $products->count())->toArray();

        $products = \DB::table('tickets')
            ->select('products.name')
            ->selectRaw('count(*) as total')
            ->join('ticket_user', 'tickets.id', 'ticket_user.ticket_id')
            ->join('products', 'products.id', 'tickets.product_id')
            ->where('ticket_user.user_id', $user->id)
            ->groupBy('tickets.product_id')
            ->get();

        $zones = \DB::table('zones')
            ->select('zones.name')
            ->selectRaw('count(*) as total')
            ->join('ticket_user', 'zones.id', 'ticket_user.zone_id')
            ->where('ticket_user.user_id', $user->id)
            ->groupBy('zones.id')
            ->get();

        $products = $products->merge($zones);

        return view('vendor.voyager.user.staff', compact('user', 'logs', 'products'));
    })->name('voyager.users.staff');


    Route::get('/tickets/{id}', function ($id) {

        $tickets = Ticket::where('id', $id)->get();


        return view('ticketpdf', compact('tickets'));
    })->name('voyager.tickets.show');

    Route::get('uesr/{id}/pos/report', PosUserReport::class)->name('pos.user.report');

    Route::group([
        'prefix' => '/products/{product}',
        'as' => 'voyager.products.'
    ], function () {
        Route::get('create-physical', [AdminCustomController::class, 'ticketCreatePhysical'])->name('ticketCreatePhysical');
        Route::post('create-physical', [AdminCustomController::class, 'ticketCreatePhysicalPost'])->name('ticketCreatePhysical.post');
        Route::get('download-physical', [AdminCustomController::class, 'ticketCreatePhysicalDownload'])->name('ticketCreatePhysical.download');
        Route::get('destroy-physical', [AdminCustomController::class, 'ticketCreatePhysicalDestroy'])->name('ticketCreatePhysical.destroy');
        Route::get('invite', [AdminCustomController::class, 'personalInviteForm'])->name('invite');
        Route::post('invite', [AdminCustomController::class, 'personalInvitePost'])->name('invite.post');
        Route::get('extras', [AdminCustomController::class, 'productAddExtras'])->name('extras');
    });

    Route::group([
        'prefix' => '/invites/{invite}',
        'as' => 'voyager.invites.'
    ], function () {
        Route::get('add-product', [AdminCustomController::class, 'inviteAddProduct'])->name('add-product');
        Route::post('store-product', [AdminCustomController::class, 'inviteAddProductStore'])->name('store-product');
    });


    // mass invite route
    Route::get('bulk/invites', [MassInviteController::class, 'MassInvitePage'])->name('massInvitePage');
    Route::get('bulk/personal-invites', [MassInviteController::class, 'MassPersonalInvitePage'])->name('MassPersonalInvitePage');
    Route::get('bulk/invites/get-products/{eventId}', [MassInviteController::class, 'getProducts'])->name('ajax.getProduct');
    Route::post('bulk/invites', [MassInviteController::class, 'MassInvite'])->name('MassInvite');
    Route::post('bulk/persona-invites', [MassInviteController::class, 'PersonalMassInvite'])->name('PersonalMassInvite');
    Route::get('/export-invites', [ExportController::class, 'exportInvites'])->name('Invite_export');

    Route::get('/ticket/{ticket:ticket}/extras', [AdminCustomController::class, 'ticketAddExtras'])->name('voyager.ticket.extras');

    Route::post('/products/{product}/add-extras', [AdminCustomController::class, 'productAddExtrasStore'])->name('voyager.products.add-extras');
    Route::post('/ticket/{ticket:ticket}/add-extras', [AdminCustomController::class, 'ticketAddExtrasStore'])->name('voyager.ticket.add-extras');
    Route::get('/send/email/{order}', [AdminCustomController::class, 'sendEmailOrder'])->name('send.email');
    Route::group(['prefix' => '/events/{event}/analytics'], function () {
        Route::get('/', [EventAnalyticsController::class, 'index'])->name('voyager.events.analytics');
        Route::get('/ticket-participants-report', [EventAnalyticsController::class, 'ticketParticipanReport'])->name('voyager.events.ticketParticipanReport.analytics');
        Route::get('/sales-report', [EventAnalyticsController::class, 'salesReport'])->name('voyager.events.salesReport.analytics');
        Route::get('/checkin', [EventAnalyticsController::class, 'checkinReport'])->name('voyager.events.checkinReport.analytics');
        Route::get('/pos', [EventAnalyticsController::class, 'POS'])->name('voyager.events.pos.analytics');
        Route::get('/customer-report', [EventAnalyticsController::class, 'customerReport'])->name('voyager.events.customer.analytics');
        Route::get('/invites-report', [EventAnalyticsController::class, 'invitesReport'])->name('voyager.events.invites.analytics');
        Route::get('/customer-report/{user}/orders', [EventAnalyticsController::class, 'customerReportOrders'])->name('voyager.events.customer.analytics.orders');
        Route::get('/invite-report/orders', [EventAnalyticsController::class, 'inviteReportOrders'])->name('voyager.events.invites.analytics.orders');
        Route::get('/invite-report/tickets', [EventAnalyticsController::class, 'inviteReportTickets'])->name('voyager.events.invites.analytics.tickets');
        Route::get('/customer-report/{user}/tickets', [EventAnalyticsController::class, 'customerReportTickets'])->name('voyager.events.customer.analytics.tickets');
        Route::get('/customer-report/{user}/tickets', [EventAnalyticsController::class, 'customerReportTickets'])->name('voyager.events.customer.analytics.tickets');
        Route::get('/customer-report/{user}/tickets/access-ticket', [EventAnalyticsController::class, 'giveAccessPage'])->name('voyager.events.customer.analytics.tickets.access-ticket');
        Route::post('/customer-report/{user}/tickets/access-ticket', [EventAnalyticsController::class, 'giveAccessSubmit'])->name('voyager.events.customer.analytics.tickets.access-ticket-submit');
    });


    Route::get('invites/{id}', function ($id, Request $request) {
        $invite = Invite::find($id);
        // dd($invite->id);
        $event = $invite->event;

        $orders = Order::where('invite_id', $invite->id)->get();

        return view('vendor.voyager.events.invites.inviteOrders', compact('orders', 'event'));
    })->name('voyager.invites.show');

    Route::get('orders/refund/{order}', [AdminCustomController::class, 'refund'])->name('order.refund');
    Route::get('/coupon-generate', [AdminCustomController::class, 'couponGenerate'])->name('voyager.coupon.generate');
    Route::post('/coupon-create', [AdminCustomController::class, 'couponCreate'])->name('voyager.coupon.create');
    Route::get('order/mark-as-pay/{order}', [AdminCustomController::class, 'orderMarkPay'])->name('order.mark.pay');
});
