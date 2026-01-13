<x-layout>

    <div class="row justify-content-center mt-4">
        <div class="col-md-8 col-lg-6">

            <div class="card shadow-sm border-0 rounded-4" style="border: 1px solid #f3d4da">
                <div class="ratio ratio-1x1 bg-light rounded-top-4">
                    @if($product->image)
                        <img src="{{ asset('storage/'.$product->image) }}"
                             alt="{{ $product->name }}"
                             class="w-100 h-100 object-fit-cover rounded-top-4">
                    @else
                        <div class="d-flex justify-content-center align-items-center text-secondary fw-semibold">
                            Photo here
                        </div>
                    @endif
                </div>

                @php
                    $outOfStock = $product->stock <= 0;
                @endphp

                <div class="card-body text-center">
                    {{-- nama n kategori --}}
                    <h2 class="fw-bold text-dark mb-2">{{ $product->name }}</h2>

                    <p class="mb-2">
                        <span class="badge rounded-pill"
                              style="background-color:#fdf5f6;color:#5b0b18;border:1px solid #f3d4da;">
                            {{ $product->category->name ?? 'No Category' }}
                        </span>
                    </p>

                    {{-- diskripsiii --}}
                    <p class="text-secondary mb-3">
                        {{ $product->description }}
                    </p>

                    {{-- harga --}}
                    @php
                        $hasDiscount = $product->discount_percent > 0;
                        $finalPrice  = $hasDiscount
                            ? $product->price - intval($product->price * $product->discount_percent / 100)
                            : $product->price;
                    @endphp

                    @if($hasDiscount)
                        <p class="mb-1">
                            <span class="text-muted text-decoration-line-through">
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                            </span>
                            <span class="badge bg-danger ms-1">-{{ $product->discount_percent }}%</span>
                        </p>
                    @endif

                    <p class="fw-bold fs-4 mb-4" style="color:#5b0b18;">
                        Rp {{ number_format($finalPrice, 0, ',', '.') }}
                    </p>


                    {{-- setox --}}
                    <p class="text-muted mb-2">
                        Stock:
                        @if($outOfStock)
                            <span class="text-danger fw-bold">0 (Out of stock)</span>
                        @else
                            <strong>{{ $product->stock }}</strong>
                        @endif
                    </p>

                    <div class="d-flex flex-column align-items-center gap-3 mt-2">

                        {{-- bek edit atmin --}}
                        <div class="d-flex gap-2">
                            <a href="{{ route('products.index') }}" class="btn btn-sm btn-dark">
                                Back
                            </a>

                            @auth
                                @if(auth()->user()->is_admin)
                                    <a href="{{ route('products.edit', $product->id) }}"
                                       class="btn btn-sm btn-pink btn-elevated">
                                        Edit
                                    </a>
                                @endif
                            @endauth
                        </div>

                        @auth
                            @if(!auth()->user()->is_admin)
                                @if($outOfStock)
                                    <span class="badge bg-secondary mt-2">
                                        Out of stock
                                    </span>
                                @else
                                    {{-- + apdet cart --}}
                                    @if($qtyInCart <= 0)
                                        <form method="POST" action="{{ route('cart.add', $product->id) }}"
                                              class="d-flex align-items-center gap-2">
                                            @csrf
                                            <div class="input-group input-group-sm" style="width:120px;">
                                                <button class="btn btn-outline-secondary" type="button"
                                                        onclick="this.parentElement.querySelector('input').stepDown()">
                                                    –
                                                </button>
                                                <input type="number" name="quantity" class="form-control text-center"
                                                       value="1" min="1" max="{{ $product->stock }}">
                                                <button class="btn btn-outline-secondary" type="button"
                                                        onclick="this.parentElement.querySelector('input').stepUp()">
                                                    +
                                                </button>
                                            </div>
                                            <button class="btn btn-sm btn-outline-dark d-flex align-items-center">
                                                <span class="me-1">🛒</span> Add to Cart
                                            </button>
                                        </form>
                                    @else
                                        <form method="POST" action="{{ route('cart.add', $product->id) }}"
                                              class="d-flex align-items-center gap-2">
                                            @csrf
                                            <div class="input-group input-group-sm" style="width:120px;">
                                                <button class="btn btn-outline-secondary" type="button"
                                                        onclick="this.parentElement.querySelector('input').stepDown()">
                                                    –
                                                </button>
                                                <input type="number" name="quantity" class="form-control text-center"
                                                       value="{{ $qtyInCart }}" min="0" max="{{ $product->stock }}">
                                                <button class="btn btn-outline-secondary" type="button"
                                                        onclick="this.parentElement.querySelector('input').stepUp()">
                                                    +
                                                </button>
                                            </div>
                                            <button class="btn btn-sm btn-outline-danger custom-update d-flex align-items-center">
                                                <span class="me-1">🛒</span> Update
                                            </button>
                                        </form>
                                    @endif

                                    {{-- wislis buynowh --}}
                                    <div class="d-flex gap-2 mt-2">
                                        <form method="POST" action="{{ route('wishlist.store', $product->id) }}">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-outline-secondary">
                                                ♥ Wishlist
                                            </button>
                                        </form>

                                        <a href="{{ route('products.buyNow', $product->id) }}"
                                           class="btn btn-sm btn-pink btn-elevated">
                                            Buy Now
                                        </a>
                                    </div>
                                @endif
                            @endif
                        @endauth

                    </div>
                </div>
            </div>

        </div>
    </div>

</x-layout>
