    @extends('layouts.app')

    @section('title', 'BAPPEDA Kota Kendari - Struktur Organisasi')

    @section('content')
        @include('partials.hero', [
            'breadcrumb' => [
                ['title' => 'Beranda', 'url' => route('home')],
                ['title' => 'Struktur Organisasi', 'url' => route('struktur-organisasi')]
            ]
        ])

        <!-- Struktur-organisasi Section -->
        <section class="struktur-organisasi">
            <div class="container d-flex justify-content-center p-3">
                <img src="{{ asset('images/struktur-organisasi.png') }}" alt="Struktur Organisasi" class="mb-5 img-fluid">
            </div>
        </section>
    @endsection