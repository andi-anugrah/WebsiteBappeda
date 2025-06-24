<section class="statistics-section py-5 mt-5">
    <div class="container">
        <h1 class="text-center fw-bold mb-5">STATISTIK</h1>
        
        @if($statistics->count() > 0)
            @php
                $chunks = $statistics->chunk(3); // Bagi menjadi grup 3 kolom
            @endphp
            
            @foreach($chunks as $chunk)
                @php
                    $colSize = 12 / $chunk->count(); // Hitung lebar kolom (12 dibagi jumlah item)
                @endphp
                <div class="row text-center {{ !$loop->last ? 'mb-5' : '' }}">
                    @foreach($chunk as $statistic)
                        <div class="col-md-{{ $colSize }} mb-4">
                            <h1 class="counter fw-bold text-warning mb-3" 
                                data-target="{{ $statistic->numeric_value }}">0</h1>
                            <h6 class="text-center">
                                {{ $statistic->label }}
                                @if($statistic->unit)
                                    <br><small class="text-muted">({{ $statistic->unit }})</small>
                                @endif
                            </h6>
                        </div>
                    @endforeach
                </div>
            @endforeach
        @else
            <div class="row">
                <div class="col-12 text-center">
                    <p class="text-muted">Belum ada data statistik yang tersedia.</p>
                </div>
            </div>
        @endif
    </div>
</section>