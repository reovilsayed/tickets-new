<?php

namespace App\Widgets;

use App\Models\Order;
use App\Models\Product;
use App\Models\Shop;
use Arrilot\Widgets\AbstractWidget;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use TCG\Voyager\Facades\Voyager;

class Orders extends AbstractWidget
{
    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [];

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run()
    {
        $count = Order::count();
        $string = trans_choice('Orders', $count);

        return view('voyager::dimmer', array_merge($this->config, [
            'icon'   => 'voyager-bomb',
            'title'  => "{$count} {$string}",
            'text'   => __("You have $count  $string in your database. Click on button below to view all $string."),
            'button' => [
                'text' => 'View all Orders',
                'link' => route('voyager.orders.index'),
            ],
            'image' => asset('assets/img/order.jpg'),
        ]));
    }

    /**
     * Determine if the widget should be displayed.
     *
     * @return bool
     */
    public function shouldBeDisplayed()
    {
        return Auth::user()->can('browse', Voyager::model('Post'));
    }
}