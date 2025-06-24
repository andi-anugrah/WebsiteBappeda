@extends('layouts.app')

@section('title', 'BAPPEDA Kota Kendari - Berita')

@section('additional-css')
    <link rel="stylesheet" href="{{ asset('css/berita.css') }}">
@endsection

@section('additional-js')
    <script src="{{ asset('js/news.js') }}"></script>
    <script src="{{ asset('js/pagination.js') }}"></script>
@endsection

@section('content')
    @include('partials.hero', [
        'breadcrumb' => [
            ['title' => 'Beranda', 'url' => route('home')],
            ['title' => 'Berita', 'url' => route('berita')],
        ],
    ])

    <!-- Berita Section -->
    <section class="berita-section py-4">
        <div class="container mt-3">
            <div class="row">
                <div class="col-12">
                    <h2 class="mb-4 text-center fw-bold">BERITA</h2>

                    @if ($paginatedNews->count() > 0)
                        <div class="news-container">
                            @foreach ($paginatedNews as $news)
                                <div class="news-item">
                                    <div class="news-image">
                                        @if ($news->image)
                                            <img src="{{ asset('storage/' . $news->image) }}"
                                                alt="{{ $news->title }}" class="img-fluid">
                                        @else
                                            <img src="{{ asset('images/default-news.png') }}" alt="{{ $news->title }}"
                                                class="img-fluid">
                                        @endif
                                    </div>
                                    <div class="news-content">
                                        <h5 class="news-title">{{ $news->title }}</h5>
                                        <div class="news-meta">
                                            <small class="text-muted">
                                                <i class="fa fa-calendar"></i> {{ $news->formatted_tgl_publikasi }}<br>
                                                <i class="fa fa-user"></i> {{ $news->author }}
                                            </small>
                                        </div>
                                        <div class="news-action">
                                            <a href="{{ route('berita-selengkapnya', $news->slug) }}"
                                                class="btn btn-read-more">
                                                Baca Selengkapnya
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        <div class="pagination-container">
                            {{ $paginatedNews->links('news-pagination') }}
                        </div>
                    @else
                        <!-- Jika tidak ada berita -->
                        <div class="text-center py-5">
                            <div class="mb-4">
                                <i class="fas fa-newspaper fa-4x text-muted"></i>
                            </div>
                            <h4 class="text-muted">Belum Ada Berita</h4>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection
