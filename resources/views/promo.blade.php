<x-layout title="Promo Spesial White Dove Coffee">
    <div class="container py-5">
        <div class="text-center mb-4">
            <p class="text-uppercase mb-1" style="letter-spacing:.15em; font-size:.8rem; color:#9ca3af;">
                Promo
            </p>
            <h1 class="fw-bold mb-2">Promo Spesial White Dove Coffee</h1>
            <p class="text-muted mb-0" style="font-size:.9rem;">
                Nikmati menu pilihan dengan harga lebih hemat untuk waktu terbatas.
            </p>
        </div>

        @if($promoProducts->count())
            <div class="row g-3">
                @foreach($promoProducts as $product)
                    <div class="col-6 col-md-3">
                        <div class="card h-100 border-0 shadow-sm">
                            <img src="{{ asset('storage/'.$product->image) }}"
                                 alt="{{ $product->name }}"
                                 class="card-img-top"
                                 style="height:180px; object-fit:cover;">

                            <div class="card-body text-center p-2">
                                <span class="badge bg-danger mb-1" style="font-size:.7rem;">
                                    Promo
                                </span>

                                <p class="fw-semibold mb-1" style="font-size:.9rem;">
                                    {{ \Illuminate\Support\Str::limit($product->name, 22) }}
                                </p>

                                @php
                                    $finalPrice = $product->price;
                                    if ($product->discount_percent > 0) {
                                        $finalPrice = $finalPrice - intval($finalPrice * $product->discount_percent / 100);
                                    }
                                @endphp

                                @if($product->discount_percent > 0)
                                    <p class="mb-0"
                                       style="font-size:.85rem; color:#9ca3af; text-decoration:line-through;">
                                        Rp {{ number_format($product->price,0,',','.') }}
                                    </p>
                                @endif

                                <p class="fw-bold mb-1" style="color:#5b0b18; font-size:.95rem;">
                                    Rp {{ number_format($finalPrice,0,',','.') }}
                                </p>

                                <a href="{{ route('products.show', $product->id) }}"
                                   class="btn btn-sm btn-dark rounded-pill">
                                    Lihat detail
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-center text-muted mb-0">
                Belum ada produk yang sedang promo saat ini. Silakan cek kembali nanti, ya.
            </p>
        @endif
    </div>
</x-layout>
