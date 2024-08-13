<?php

namespace App\Services;

use App\Models\Event;
use App\Models\Order;
use App\Models\Product;
use App\Services\Payment\EasyPay;
use Cart;
use Exception;
use Sohoj;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class EventReport
{

  protected Event $event;
  protected $report;
  protected function __construct(Event $event)
  {
    $this->event = $event;
  }

  protected function reportByDates()
  {
    $data = [];
    foreach ($this->event->dates() as $date) {
      $data[$date] = $this->singleDayReport($date);
    }
    $this->report['by_dates'] = $data;
  }
  private function singleDayReport($date)
  {
    $tickets = (clone $this->event)->tickets()->whereJsonContains('dates', $date);
    return [
      'products' => Product::whereDate('start_date','<=',$date)->whereDate('end_date','>=',$date)->get(),
      'participants' => (clone $tickets)->count(),
      'checked_in' => (clone $tickets)->where('status', 1)->count(),
      'returned' => (clone $tickets)->where('status', 3)->count(),
      'type' => [
        'invite' => [
          'participants' => (clone $tickets)->where('type', 'invite')->count(),
          'checked_in' => (clone $tickets)->where('type', 'invite')->where('status', 1)->count(),
          'returned' => (clone $tickets)->where('type', 'invite')->where('status',3)->count()
        ],
        'paid' => [
          'participants' => (clone $tickets)->where('type', 'paid')->count(),
          'checked_in' => (clone $tickets)->where('type', 'paid')->where('status', 1)->count(),
          'returned' => (clone $tickets)->where('type', 'paid')->where('status',3)->count()
        ]
      ]
    ];
  }

  protected function reportBySingleType($type)
  {
    $tickets = (clone $this->event)->tickets()->where('type', $type);
    $products = (clone $tickets)->select('product_id')->distinct()->get()->pluck('product_id')->mapWithKeys(function ($product) {
      $tickets = (clone $this->event)->tickets()->where('product_id', $product);
      return  [
        $product => [
          'product' => Product::find($product),
          'participants' => (clone $tickets)->count(),
          'checked_in' => (clone $tickets)->where('status', 1)->count(),
          'returned' => (clone $tickets)->where('status', 3)->count(),
        ]

      ];
    })->toArray();
    return [
      'participants' => (clone $tickets)->count(),
      'checked_in' => (clone $tickets)->where('status', 1)->count(),
      'products' => $products
    ];
  }
  protected function reportByTypes()
  {
    $types = ['paid', 'invite'];
    $data = [];
    foreach ($types as $type) {
      $data[$type] = $this->reportBySingleType($type);
    }
    $this->report['by_type'] = $data;
  }
  protected function make()
  {
    $this->reportByDates();
    $this->reportByTypes();
    return $this->report;
  }

  public static function generate(Event $event)
  {
    return (new self($event))->make();
  }
}
