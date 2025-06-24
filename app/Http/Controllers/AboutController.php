<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function struktur_organisasi()
    {
        return view('struktur-organisasi');
    }
    
    public function tugas_fungsi()
    {
        return view('tugas-fungsi');
    }
}