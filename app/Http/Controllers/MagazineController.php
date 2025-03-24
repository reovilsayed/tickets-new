<?php

namespace App\Http\Controllers;

use App\Models\Magazine;

class MagazineController extends Controller
{
    public function index()
    {
        $magazines = Magazine::latest()->paginate(10);

        return view('pages.magazines.index', ['magazines' => $magazines]);
    }

    public function show($slug)
    {
        $magazine = Magazine::where('slug', $slug)->firstOrFail();
        return view('pages.magazines.show', ['magazine' => $magazine, 'is_invite' => true]);
    }
}
