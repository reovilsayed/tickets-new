<?php

namespace App\Widgets;

use App\Models\Shop;
use Arrilot\Widgets\AbstractWidget;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use TCG\Voyager\Facades\Voyager;

class Shops extends AbstractWidget
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
        $count = Shop::count();
        $string = trans_choice('Shops', $count);

        return view('voyager::dimmer', array_merge($this->config, [
            'icon'   => 'voyager-pie-chart',
            'title'  => "{$count} {$string}",
            'text'   => __("You have $count  $string in your database. Click on button below to view all $string."),
            'button' => [
                'text' => 'View all Shops',
                'link' => route('admin.shop.index'),
            ],
            'image' => asset('assets/img/shop.jpg'),
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