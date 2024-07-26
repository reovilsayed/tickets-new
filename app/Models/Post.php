<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends \TCG\Voyager\Models\User
{
    use HasFactory;
    public function scopePublished($query)
    {
        return $query->where('status', 'PUBLISHED');
    }
    public function category()  {
        return $this->belongsTo(Category::class);
    }
    public function scopeFilter($query)
    {
        return $query
        ->when(request()->filled('category'), function ($q) {
            return $q->whereHas('category', function ($query) {
                $query->where('slug', request()->category);
            });
        })
        ->when(
            request()->has('search'),
            function ($q) {
                return $q->where('title', 'LIKE', '%' . request()->search . '%')->orWhere('body', 'LIKE', '%' . request()->search . '%');
            });
    }
}
