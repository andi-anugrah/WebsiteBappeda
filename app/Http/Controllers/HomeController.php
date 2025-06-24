<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Ambil 3 berita terbaru yang sudah dipublish
        $latestNews = Berita::latest()
            ->published()
            ->take(3)
            ->get();

        // Ambil data statistik untuk homepage
        $statistics = \App\Models\Statistic::active()->ordered()->get();
        
        return view('home', compact('latestNews', 'statistics'));
    }
}