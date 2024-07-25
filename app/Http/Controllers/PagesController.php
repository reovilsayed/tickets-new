<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function home()
    {
        return view('pages.index');
    }
    public function event_details()
    {
        return view('pages.event_details');
    }
    public function event_tickets()
    {
        return view('pages.event_tickets');
    }
    public function event_speaker()
    {
        return view('pages.event_speaker');
    }
    public function event_checkout()
    {
        return view('pages.event_checkout');
    }
    public function contact()
    {
        return view('pages.contact');
    }
    public function about()
    {
        return view('pages.about');
    }
}
