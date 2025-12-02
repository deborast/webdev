<x-layout>

    <div class="row justify-content-center mt-4">
        <div class="col-md-8 col-lg-6">

            <div class="card shadow-sm border-0" style="border: 1px solid #ff8800;">
                <div class="ratio ratio-4x3 bg-light">
                    <div class="d-flex justify-content-center align-items-center text-secondary fw-semibold">
                        Photo here
                    </div>
                </div>

                <div class="card-body text-center">

                    <h2 class="fw-bold text-dark mb-2">
                        {{ $product->name }}
                    </h2>

                    <p class="mb-2">
                        <span class="badge bg-warning text-dark">
                            {{ $product->category->name ?? 'No Category' }}
                        </span>
                    </p>

                    <p class="text-secondary mb-3">
                        {{ $product->description }}
                    </p>

                    <p class="fw-bold fs-4 mb-4" style="color:#ff7b00;">
                        Rp {{ number_format($product->price, 0, ',', '.') }}
                    </p>

                    <div class="d-flex gap-2 justify-content-center">
                        <a href="{{ route('products.index') }}"
                           class="btn btn-dark">
                           ← Back
                        </a>

                        <a href="{{ route('products.edit', $product->id) }}"
                           class="btn btn-pink">
                           Edit
                        </a>
                    </div>

                </div>
            </div>

        </div>
    </div>

</x-layout>
