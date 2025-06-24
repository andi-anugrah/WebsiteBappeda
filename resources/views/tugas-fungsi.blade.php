@extends('layouts.app')

@section('title', 'BAPPEDA Kota Kendari - Tugas & Fungsi')

@section('content')
    @include('partials.hero', [
        'breadcrumb' => [
            ['title' => 'Beranda', 'url' => route('home')],
            ['title' => 'Tugas & Fungsi', 'url' => route('tugas-fungsi')]
        ]
    ])

    <!-- Struktur-organisasi Section -->
    <section class="tugas-fungsi">
        <div class="container p-2">
            <h1 class="title fw-bold mb-5">TUGAS & FUNGSI BAPPEDA</h1>
            <h2 class="sub-title fw-bold text-start">Tugas Bappeda</h2>
            <h4 class="description pb-4">
                Badan bertugas membantu Wali Kota dalam melaksanakan fungsi penunjang urusan pemerintahan yang menjadi kewenangan fungsi penunjang urusan pemerintah yang menjadi kewenangan Daerah dan tugas pembentukan di bidang perencanaan pembangunan daerah, penelitian dan pengembangan. 
            </h4>

            <h2 class="sub-title fw-bold text-start">Fungsi Bappeda</h2>
            <h4 class="description">Badan menyelenggarakan fungsi:
                <ol class="list">
                    <li>Penyusunan kebijakan teknis bidang perencanaan pembangunan daerah, penelitian dan pengembangan;</li>
                    <li>Pelaksanaan tugas dukungan teknis bidang perencanaan pembangunan daerah, penelitian dan pengembangan;</li>
                    <li>Pemantauan, evaluasi dan pelaporan pelaksanaan tugas dukungan teknis bidang perencanaan pembangunan daerah, penelitian dan pengembangan; dan</li>
                    <li>Pelaksanaan fungsi lain yang diberikan oleh Wali Kota terkait dengan tugas dan fungsi badan.</li>
                </ol>
            </h4>
        </div>
    </section>
@endsection