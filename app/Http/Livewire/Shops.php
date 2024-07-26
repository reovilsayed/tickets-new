<?php

namespace App\Http\Livewire;

use App\Models\Shop;
use Livewire\Component;

class Shops extends Component
{
    public $latest_shops;
    public $more_shops = true;
    public function mount()
    {
        $this->latest_shops = Shop::where("status", 1)
            ->whereHas('products', function ($query) {
                $query->whereNull('parent_id');
            })
            ->latest()
            ->limit(4)
            ->get();
        $latestShopIds = $this->latest_shops->pluck('id')->toArray();
        $newShops = Shop::where("status", 1)
            ->whereHas('products', function ($query) {
                $query->whereNull('parent_id');
            })
            ->whereNotIn('id', $latestShopIds)
            ->latest()
            ->limit(5)
            ->get();
        if (count($newShops) == 0) {
            $this->more_shops =  false;
        }
    }

    public function addMoreShops()
    {
        $latestShopIds = $this->latest_shops->pluck('id')->toArray();
        $newShops = Shop::where("status", 1)
            ->whereHas('products', function ($query) {
                $query->whereNull('parent_id');
            })
            ->whereNotIn('id', $latestShopIds)
            ->latest()
            ->limit(5)
            ->get();
        if (count($newShops) == 0) {
            $this->more_shops =  false;
        }
        $this->latest_shops = $this->latest_shops->concat($newShops);
    }

    public function render()
    {
        return view('livewire.shops');
    }
}
