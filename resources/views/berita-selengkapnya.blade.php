@extends('layouts.app')

@section('title', 'BAPPEDA Kota Kendari - ' . ($berita->title ?? 'Berita'))

@section('additional-css')
<link rel="stylesheet" href="{{ asset('css/berita.css') }}">
<link rel="stylesheet" href="{{ asset('css/hide-attachment-info.css') }}">
@endsection

@section('additional-js')
    <script src="{{ asset('js/news.js') }}"></script>
    <script src="{{ asset('js/pagination.js') }}"></script>
@endsection

@section('content')
    <!-- Berita Section -->
    <div class="container mt-5">
        <div class="row">
            <div class="col-12">
                <!-- Tombol Kembali -->
                <div class="mb-4">
                    <a href="{{ route('berita') }}" class="btn btn-outline-dark">
                        <i class="fas fa-arrow-left me-2"></i>Kembali ke Halaman Berita
                    </a>
                </div>

                <!-- Article Content -->
                <article class="card shadow-sm">
                    <div class="card-body">
                        <!-- Title -->
                        <h1 class="card-title mb-4 fw-bold text-dark">
                            {{ $berita->title }}
                        </h1>
                        
                        <!-- Meta Information -->
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <div class="d-flex align-items-center mb-2">
                                    <div class="d-flex align-items-center me-4">
                                        <i class="fas fa-calendar-alt text-muted me-2"></i>
                                        <small class="text-muted">
                                            Dipublikasikan: {{ $berita->formatted_tgl_publikasi }}
                                        </small>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-user text-muted me-2"></i>
                                        <small class="text-muted">
                                            Penulis: {{ $berita->author }}
                                        </small>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                        
                        <!-- Featured Image -->
                        @if($berita->image)
                        <div class="mb-4 text-center">
                            <img src="{{ asset('storage/' . $berita->image) }}" 
                                 alt="{{ $berita->title }}" 
                                 class="img-fluid rounded shadow-sm" 
                                 style="max-height: 400px; width: auto;">
                        </div>
                        @endif
                        
                        <!-- Content -->
                        <div class="content">
                            <div class="text-justify lh-lg">
                                {!! $berita->content !!}
                            </div>
                        </div>
                        
                        <!-- Share Buttons -->
                        <div class="mt-4 pt-3 border-top">
                            <h6 class="text-muted mb-3">Bagikan:</h6>
                            <div class="d-flex gap-2">
                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->fullUrl()) }}" 
                                   target="_blank" 
                                   class="btn btn-outline-primary btn-sm">
                                    <i class="fab fa-facebook-f me-1"></i>Facebook
                                </a>
                                <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->fullUrl()) }}&text={{ urlencode($berita->title) }}" 
                                   target="_blank" 
                                   class="btn btn-outline-info btn-sm">
                                    <i class="fab fa-twitter me-1"></i>Twitter
                                </a>
                                <a href="https://wa.me/?text={{ urlencode($berita->title . ' ' . request()->fullUrl()) }}" 
                                   target="_blank" 
                                   class="btn btn-outline-success btn-sm">
                                    <i class="fab fa-whatsapp me-1"></i>WhatsApp
                                </a>
                            </div>
                        </div>
                    </div>
                </article>
            </div>
        </div>
    </div>
@endsection