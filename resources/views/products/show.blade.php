<x-layout>

    <div class="row justify-content-center mt-4">
        <div class="col-md-8 col-lg-6">

            <div class="card shadow-sm border-0 rounded-4" style="border: 1px solid #f3d4da;">
                <div class="ratio ratio-4x3 bg-light rounded-top-4">
                    <div class="d-flex justify-content-center align-items-center text-secondary fw-semibold">
                        Photo here
                    </div>
                </div>

                <div class="card-body text-center">

                    <h2 class="fw-bold text-dark mb-2">
                        {{ $product->name }}
                    </h2>

                    <p class="mb-2">
                        <span class="badge rounded-pill"
                              style="background-color:#fdf5f6; color:#5b0b18; border:1px solid #f3d4da;">
                            {{ $product->category->name ?? 'No Category' }}
                        </span>
                    </p>

                    <p class="text-secondary mb-3">
                        {{ $product->description }}
                    </p>

                    <p class="fw-bold fs-4 mb-4" style="color:#5b0b18;">
                        Rp {{ number_format($product->price, 0, ',', '.') }}
                    </p>

                    <div class="d-flex gap-2 justify-content-center flex-wrap">
                        <a href="{{ route('products.index') }}"
                           class="btn btn-sm btn-dark">
                            ← Back
                        </a>

                        <a href="{{ route('products.edit', $product->id) }}"
                           class="btn btn-sm btn-pink btn-elevated">
                            Edit
                        </a>

                        @auth
                            @if($qtyInCart <= 0)
                                <form method="POST" action="{{ route('cart.add', $product->id) }}">
                                    @csrf
                                    <button class="btn btn-sm btn-outline-dark d-flex align-items-center justify-content-center">
                                        <span class="me-1">🛒</span> Add to Cart
                                    </button>
                                </form>
                            @else
                                <form method="POST" action="{{ route('cart.add', $product->id) }}"
                                      class="d-flex align-items-center justify-content-center gap-2">
                                    @csrf
                                    <div class="input-group input-group-sm" style="width:120px;">
                                        <button class="btn btn-outline-secondary" type="button"
                                                onclick="this.parentElement.querySelector('input').stepDown()">
                                            –
                                        </button>
                                        <input type="number" name="quantity" class="form-control text-center"
                                               value="{{ $qtyInCart }}" min="0">
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
                        @endauth
                    </div>

                </div>
            </div>

        </div>
    </div>

</x-layout>
