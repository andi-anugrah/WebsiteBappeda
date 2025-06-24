@extends('layouts.app')

@section('title', $pageTitle . ' - BAPPEDA Kota Kendari')

@section('additional-css')
    <link rel="stylesheet" href="{{ asset('css/dokumen.css') }}">
@endsection

@section('content')
    @include('partials.hero', [
        'breadcrumb' => [
            ['title' => 'Beranda', 'url' => route('home')],
            ['title' => $pageTitle, 'url' => route('dokumen.kategori', $kategori)],
        ],
    ])
    <div class="container-fluid px-4">
        <div class="documents-page mx-auto">

            <!-- Filter Section -->
            <div class="filter-section">
                <div class="row">
                    <div class="col-md-4">
                        <div class="filter-group">
                            <label for="kategori-filter" class="filter-label">Kategori</label>
                            <select id="kategori-filter" class="form-select">
                                <option value="all" {{ $kategori === 'all' ? 'selected' : '' }}>Semua Kategori</option>
                                @foreach ($kategoriOptions as $key => $label)
                                    <option value="{{ $key }}" {{ $kategori === $key ? 'selected' : '' }}>
                                        {{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="filter-group">
                            <label for="search-input" class="filter-label">Cari Dokumen</label>
                            <div class="search-wrapper">
                                <input type="text" id="search-input" class="form-control"
                                    placeholder="Cari dokumen berdasarkan judul..." value="{{ $search }}">
                                <button type="button" id="search-btn" class="btn">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Documents Table -->
            <div class="documents-table-wrapper">
                <div class="table-responsive">
                    <table class="table documents-table">
                        <thead>
                            <tr>
                                <th width="5%" class="text-center">No.</th>
                                <th width="80%">Judul Dokumen</th>
                                <th width="15%">Unduh</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($documents as $index => $document)
                                <tr>
                                    <td class="text-center">{{ $documents->firstItem() + $index }}</td>
                                    <td>
                                        {{ $document->judul_dokumen }}
                                    </td>
                                    <td>
                                        @if ($document->file_dokumen)
                                            <a href="{{ route('dokumen.download', $document->id) }}"
                                                class="btn btn-primary btn-sm download-btn">
                                                <i class="fas fa-download"></i> Unduh
                                            </a>
                                        @else
                                            <span class="text-muted">Tidak ada file</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4">
                                        <div class="no-data">
                                            <i class="fas fa-folder-open fa-3x text-muted mb-3"></i>
                                            <p class="text-muted d-flex justify-content-center">Tidak ada dokumen yang ditemukan.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Pagination Section -->
            @if($documents->hasPages())
            <div class="pagination-wrapper">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="showing-info">
                            Showing {{ $documents->firstItem() }} to {{ $documents->lastItem() }} 
                            of {{ $documents->total() }} entries
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="pagination-nav">
                            <nav aria-label="Pagination Navigation">
                                <ul class="pagination mb-0">
                                    {{-- Previous Page Link --}}
                                    @if ($documents->onFirstPage())
                                        <li class="page-item disabled">
                                            <span class="page-link">
                                                <i class="fas fa-chevron-left"></i>
                                            </span>
                                        </li>
                                    @else
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $documents->previousPageUrl() }}" rel="prev">
                                                <i class="fas fa-chevron-left"></i>
                                            </a>
                                        </li>
                                    @endif

                                    {{-- Pagination Elements --}}
                                    @foreach ($documents->getUrlRange(1, $documents->lastPage()) as $page => $url)
                                        @if ($page == $documents->currentPage())
                                            <li class="page-item active">
                                                <span class="page-link">{{ $page }}</span>
                                            </li>
                                        @else
                                            <li class="page-item">
                                                <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                            </li>
                                        @endif
                                    @endforeach

                                    {{-- Next Page Link --}}
                                    @if ($documents->hasMorePages())
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $documents->nextPageUrl() }}" rel="next">
                                                <i class="fas fa-chevron-right"></i>
                                            </a>
                                        </li>
                                    @else
                                        <li class="page-item disabled">
                                            <span class="page-link">
                                                <i class="fas fa-chevron-right"></i>
                                            </span>
                                        </li>
                                    @endif
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
@endsection

@section('additional-js')
    <script src="{{ asset('js/dokumen.js') }}"></script>
@endsection
