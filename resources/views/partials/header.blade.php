<!-- Header -->
<header class="sticky-top">
    <nav class="navbar navbar-expand-lg py-3">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <img src="{{ asset('images/Logo Kota Kendari.png') }}" alt="Logo Kendari" class="logo-kendari">
                <img src="{{ asset('images/logo bappeda FIX.png') }}" alt="Logo Bappeda" class="logo-bappeda mx-2">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">BERANDA</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle {{ request()->routeIs('struktur-organisasi', 'tugas-fungsi') ? 'active' : '' }}" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            TENTANG
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <li><a class="dropdown-item" href="{{ route('struktur-organisasi') }}">Struktur Organisasi</a></li>
                            <li><a class="dropdown-item" href="{{ route('tugas-fungsi') }}">Tugas & Fungsi</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('berita') ? 'active' : '' }}" href="{{ route('berita') }}">BERITA</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle {{ request()->routeIs('rpjmd', 'rpjpd', 'rkpd', 'renja', 'renstra', 'dokumen-lainnya') ? 'active' : '' }}" href="#" id="navbarDropdownMenuLink2" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            DOKUMEN
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink2">
                            <li><a class="dropdown-item {{ request()->routeIs('rpjmd') ? 'active' : '' }}" href="{{ route('dokumen.kategori', 'rpjmd') }}">RPJMD</a></li>
                            <li><a class="dropdown-item {{ request()->routeIs('rpjpd') ? 'active' : '' }}" href="{{ route('dokumen.kategori', 'rpjpd') }}">RPJPD</a></li>
                            <li><a class="dropdown-item {{ request()->routeIs('rkpd') ? 'active' : '' }}" href="{{ route('dokumen.kategori', 'rkpd') }}">RKPD</a></li>
                            <li><a class="dropdown-item {{ request()->routeIs('renja') ? 'active' : '' }}" href="{{ route('dokumen.kategori', 'renja') }}">RENJA</a></li>
                            <li><a class="dropdown-item {{ request()->routeIs('renstra') ? 'active' : '' }}" href="{{ route('dokumen.kategori', 'renstra') }}">RENSTRA</a></li>
                            <li><a class="dropdown-item {{ request()->routeIs('dokumen_lainnya') ? 'active' : '' }}" href="{{ route('dokumen.kategori', 'dokumen_lainnya') }}">Dokumen Lainnya</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>