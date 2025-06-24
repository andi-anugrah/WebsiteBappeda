<!-- Hero Section -->
<div class="hero-section">
    <img src="{{ asset('images/bg-bappeda.jpeg') }}" alt="Bg-Bappeda">
    <div class="hero-overlay"></div>
    <div class="hero-content">
        @if(isset($breadcrumb) && is_array($breadcrumb))
            <h2>
                @foreach($breadcrumb as $key => $item)
                    <a href="{{ $item['url'] }}">{{ $item['title'] }}</a>
                    @if($key < count($breadcrumb) - 1)
                        <span class="text-white mx-1">/</span>
                    @endif
                @endforeach
            </h2>
        @else
            <h1 class="fw-bold">BAPPEDA KOTA KENDARI</h1>
            <h1 class="fw-bold">(BADAN PERENCANAAN PEMBANGUNAN DAERAH)</h1>
        @endif
    </div>
    <div class="wave">
        <svg viewBox="0 0 1440 320">
            <path fill="#fff" fill-opacity="1" d="M0,160 Q720,320 1440,160 L1440,320 L0,320Z"></path>
        </svg>
    </div>
</div>
