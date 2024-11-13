<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $title = 'Dashboard';
        $breadcrumbs = [
            ['name' => 'Home', 'url' => '/'],
        ];

        $hour = \Carbon\Carbon::now('Asia/Jakarta')->format('H');
        $greeting = '';

        if ($hour < 12) {
            $greeting = 'Selamat Pagi';
        } elseif ($hour < 17) {
            $greeting = 'Selamat Siang';
        } else {
            $greeting = 'Selamat Sore';
        }

        $user = Auth::user();
        $today = \Carbon\Carbon::now('Asia/Jakarta')->isoFormat('dddd, D MMMM YYYY');

        return view('pages.home', compact('greeting', 'user', 'today', 'title', 'breadcrumbs'));
    }
}

