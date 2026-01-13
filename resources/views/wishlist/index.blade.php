<x-layout>

    <h3 class="mb-4">My Wishlist</h3>

    @if(session('success'))
        <div class="alert-maroon d-flex align-items-center mb-3">
            <span class="alert-icon">✅</span>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if($wishlists->count() === 0)
        <div class="alert-maroon d-flex align-items-center mb-3">
            <span class="alert-icon">ℹ️</span>
            <span>
                Your wishlist is empty.
                <a href="{{ route('products.index') }}" class="link-maroon text-decoration-underline">
                    Browse products
                </a>
                to add favorites.
            </span>
        </div>
    @else
        <div class="row">
            @foreach($wishlists as $item)
                @php($product = $item->product)
                @if($product)
                    <div class="col-md-4 mb-3">
                        <div class="card shadow-sm border-0 h-100">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title mb-1">{{ $product->name }}</h5>
                                <p class="text-muted small mb-2">
                                    {{ $product->category->name ?? '-' }}
                                </p>
                                <p class="mb-2 fw-semibold">
                                    Rp {{ number_format($product->price, 0, ',', '.') }}
                                </p>

                                <div class="mt-auto d-flex justify-content-between">
                                    <a href="{{ route('products.show', $product->id) }}" class="btn btn-sm btn-outline-secondary">
                                        View
                                    </a>
                                    <form method="POST" action="{{ route('wishlist.destroy', $product->id) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger">
                                            Remove
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    @endif

</x-layout>
