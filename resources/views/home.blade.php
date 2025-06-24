@extends('layouts.app') 

@section('title', 'BAPPEDA Kota Kendari - Beranda')

@section('additional-js')
    <script src="{{ asset('js/counter-statistic.js') }}"></script>
@endsection

@section('content')
    @include('partials.hero')

    <!-- Planning Section -->
    <section class="planning-section py-5">
        <div class="container">
            <div class="row">
                <div class="col-md-6 px-4">
                    <img src="{{ asset('images/bappeda.png') }}" class="img-fluid rounded" alt="bappeda">
                </div>
                <div class="col-md-6 px-4">
                    <h1 class="fw-bold mb-3">Badan Perencanaan Pembangunan Daerah</h1>
                    <p>
                        Bappeda mempunyai tugas menyusun, mengoordinasikan, dan mengawasi perencanaan pembangunan agar selaras dengan visi dan misi daerah serta kebijakan nasional.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Document Section -->
    <section class="document-section py-5 mt-5">
        <div class="container">
            <h1 class="text-center fw-bold mb-5">DOKUMEN PUBLIK</h1>
            <div class="row justify-content-center">
                <div class="col-lg-4 col-md-6 col-sm-6 mb-4 d-flex justify-content-center">
                    <div class="document-card text-center">
                        <a href="{{ route('dokumen.kategori', 'rpjmd') }}">
                            <img src="{{ asset('images/icon_book.png') }}" alt="RPJMD" class="img-fluid mt-4">
                            <p class="mt-4 fw-bold">RPJMD</p>
                        </a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6 mb-4 d-flex justify-content-center">
                    <div class="document-card text-center">
                        <a href="{{ route('dokumen.kategori', 'rpjpd') }}">
                            <img src="{{ asset('images/icon_book.png') }}" alt="RPJPD" class="img-fluid mt-4">
                            <p class="mt-4 fw-bold">RPJPD</p>
                        </a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6 mb-4 d-flex justify-content-center">
                    <div class="document-card text-center">
                        <a href="{{ route('dokumen.kategori', 'rkpd') }}">
                            <img src="{{ asset('images/icon_book.png') }}" alt="RKPD" class="img-fluid mt-4">
                            <p class="mt-4 fw-bold">RKPD</p>
                        </a>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center mt-3">
                <div class="col-lg-4 col-md-6 col-sm-6 mb-4 d-flex justify-content-center">
                    <div class="document-card text-center">
                        <a href="{{ route('dokumen.kategori', 'renja') }}">
                            <img src="{{ asset('images/icon_book.png') }}" alt="RENJA" class="img-fluid mt-4">
                            <p class="mt-4 fw-bold">RENJA</p>
                        </a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6 mb-4 d-flex justify-content-center">
                    <div class="document-card text-center">
                        <a href="{{ route('dokumen.kategori', 'renstra') }}">
                            <img src="{{ asset('images/icon_book.png') }}" alt="RENSTRA" class="img-fluid mt-4">
                            <p class="mt-4 fw-bold">RENSTRA</p>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- News Section -->
    <section class="news-section py-5 mt-5">
        <div class="container">
            <h1 class="text-center fw-bold mb-5">BERITA</h1>
            <div class="row d-flex justify-content-between">
                @forelse($latestNews as $news)
                <div class="col-md-4 mb-4">
                    <div class="card w-100 h-100 border-0">
                        @if($news->image)
                            <img src="{{ asset('storage/' . $news->image) }}" class="card-img-top rounded-4" alt="{{ $news->title }}">
                        @else
                            <img src="{{ asset('images/default-news.png') }}" class="card-img-top rounded-4" alt="{{ $news->title }}">
                        @endif
                        <div class="card-body p-0 pt-2">
                            <p class="text-warning fw-bold mt-3">{{ $news->tgl_publikasi->format('Y-m-d') }}</p>
                            <a href="{{ route('berita-selengkapnya', $news->slug) }}" class="text-decoration-none">
                                <h5 class="card-title fw-bold text-dark">{{ $news->title }}</h5>
                            </a>
                            <p class="card-text small text-justify">{{ $news->getExcerptAttribute(200) }}</p>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12 text-center">
                    <div class="py-5">
                        <i class="fas fa-newspaper fa-4x text-muted mb-3"></i>
                        <h4 class="text-muted">Belum Ada Berita</h4>
                    </div>
                </div>
                @endforelse
            </div>
            
            <!-- Tombol Lihat Semua Berita -->
            @if($latestNews->count() > 0)
            <div class="text-center mt-4">
                <a href="{{ route('berita') }}" class="btn-lg">
                    Lihat Semua Berita
                    <i class="fas fa-arrow-right ms-2"></i>
                </a>
            </div>
            @endif
        </div>
    </section>

    <!-- Statistics Section -->
    @include('statistics', ['statistics' => $statistics])

    {{-- <section class="statistics-section py-5 mt-5">
        <div class="container">
            <h1 class="text-center fw-bold mb-5">STATISTIK</h1>
            <div class="row text-center mb-5">
                <div class="col-md-4 mb-4">
                    <h1 class="counter fw-bold text-warning mb-3" data-target="351085">0</h1>
                    <h5 class="text-center">Jumlah Penduduk</h5>
                </div>
                <div class="col-md-4 mb-4">
                    <h1 class="counter fw-bold text-warning mb-3" data-target="59">0</h1>
                    <h5 class="text-center">Jumlah Program Prioritas <br> Pembangunan</h5>
                </div>
                <div class="col-md-4 mb-4">
                    <h1 class="counter fw-bold text-warning mb-3" data-target="84,85">0</h1>
                    <h5 class="text-center">Indeks Pembangunan Manusia (%)</h5>
                </div>
            </div>
            <div class="row text-center">
                <div class="col-md-4 mb-4">
                    <h1 class="counter fw-bold text-warning mb-3" data-target="9248">9.248</h1>
                    <h5 class="text-center">Jumlah Pengangguran</h5>
                </div>
                <div class="col-md-4 mb-4">
                    <h1 class="counter fw-bold text-warning mb-3" data-target="3,29">0</h1>
                    <h5 class="text-center">Pertumbuhan Ekonomi (%)</h5>
                </div>
                <div class="col-md-4 mb-4">
                    <h1 class="counter fw-bold text-warning mb-3" data-target="4,59">0</h1>
                    <h5 class="text-center">Persentase Penduduk Miskin (%)</h5>
                </div>
            </div>
        </div>
    </section> --}}
@endsection