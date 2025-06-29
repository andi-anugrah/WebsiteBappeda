<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

class NewsController extends Controller
{
    public function berita(Request $request)
    {
        // Ambil data berita dari database dengan pagination
        $paginatedNews = Berita::latest() // menggunakan scope latest dari model
            ->published() // hanya berita yang sudah dipublish
            ->paginate(6); // 6 berita per halaman

        return view('berita', compact('paginatedNews'));
    }

    public function BeritaSelengkapnya($slug)
    {
        // Cari berita berdasarkan slug
        $berita = Berita::where('slug', $slug)
            ->published()
            ->firstOrFail();

        return view('berita-selengkapnya', compact('berita'));
    }
}