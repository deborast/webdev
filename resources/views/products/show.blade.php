<x-layout>

    <div class="card shadow-sm border-0 mt-4" style="border: 1px solid #ff8800;">
        <div class="card-body">

            <h2 class="fw-bold text-dark mb-3">
                {{ $product['name'] }}
            </h2>

            <p class="text-secondary mb-3">
                {{ $product['description'] }}
            </p>

            <p class="fw-bold fs-4" style="color:#ff7b00;">
                Rp {{ number_format($product['price'], 0, ',', '.') }}
            </p>

            <div class="d-flex gap-2 mt-4">

                <a href="{{ route('products.index') }}"
                   class="btn btn-dark">
                   ← Back
                </a>

                <a href="{{ route('products.edit', $product['id']) }}"
                    class="btn btn-pink">
                    Edit
                </a>


            </div>

        </div>
    </div>

</x-layout>
