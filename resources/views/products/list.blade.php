<x-layout>

    @if(session('success'))
        <div class="alert alert-maroon d-flex align-items-center mb-3">
            <span class="alert-icon">✅</span>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-maroon d-flex align-items-center mb-3">
            <span class="alert-icon">⚠️</span>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    @auth
        @if(auth()->user()->isAdmin())
            <div class="mb-3 d-flex justify-content-end gap-2">
                <a href="{{ route('categories.index') }}" class="btn btn-outline-secondary btn-elevated">
                    Manage Categories
                </a>
                <a href="{{ route('products.create') }}" class="btn btn-pink btn-elevated">
                    + Add New Product
                </a>
            </div>
        @endif
    @endauth

    <div id="search-section" class="card shadow-sm mb-4 border-0">
        <div class="card-body">
            <form method="GET" action="{{ route('products.index') }}">
                <div class="row g-2 align-items-center">
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-text">🔍</span>
                            <input type="text" name="q" class="form-control"
                                   value="{{ request('q') }}" placeholder="Search by name or description">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="dropdown w-100">
                            <button class="btn btn-outline-secondary w-100 dropdown-toggle" type="button"
                                    data-bs-toggle="dropdown">
                                Filter options
                            </button>
                            <div class="dropdown-menu p-3" style="min-width:320px;">
                                <div class="mb-2">
                                    <label class="form-label">Price range</label>
                                    <div class="d-flex gap-2">
                                        <input type="number" name="min_price" class="form-control form-control-sm"
                                               value="{{ request('min_price') }}" placeholder="Min">
                                        <input type="number" name="max_price" class="form-control form-control-sm"
                                               value="{{ request('max_price') }}" placeholder="Max">
                                    </div>
                                </div>

                                <div class="mb-2">
                                    <label class="form-label">Sort By</label>
                                    <select name="sort_by" class="form-select form-select-sm">
                                        <option value="name"  {{ request('sort_by') == 'name'  ? 'selected' : '' }}>Name</option>
                                        <option value="price" {{ request('sort_by') == 'price' ? 'selected' : '' }}>Price</option>
                                    </select>
                                </div>

                                <div class="mb-2">
                                    <label class="form-label">Order</label>
                                    <select name="sort_dir" class="form-select form-select-sm">
                                        <option value="asc"  {{ request('sort_dir') == 'asc'  ? 'selected' : '' }}>Ascending</option>
                                        <option value="desc" {{ request('sort_dir') == 'desc' ? 'selected' : '' }}>Descending</option>
                                    </select>
                                </div>

                                <button class="btn btn-sm btn-pink w-100 mt-1">Search</button>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <button class="btn btn-pink w-100">Search</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="mb-3 d-flex align-items-center flex-wrap gap-2">
        <strong class="me-2">Categories:</strong>

        <a href="{{ route('products.index', array_merge(request()->except('page','category_id'))) }}"
           class="text-decoration-none">
            <span class="category-pill {{ empty($currentCategoryId) ? 'category-pill-active' : '' }}">
                All
            </span>
        </a>

        @foreach($categories as $c)
            <a href="{{ route('products.index', array_merge(request()->except('page'), ['category_id' => $c->id])) }}"
               class="text-decoration-none">
                <span class="category-pill {{ (string)$currentCategoryId === (string)$c->id ? 'category-pill-active' : '' }}">
                    {{ $c->name }}
                </span>
            </a>
        @endforeach
    </div>

    {{-- rikomen tuk user --}}
    @if(isset($recommendedProducts) && $recommendedProducts->isNotEmpty())
        <div class="mb-4">
            <h5 class="mb-2">Recommended for you</h5>
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 g-3">
                @foreach($recommendedProducts as $rp)
                    <div class="col">
                        <div class="card shadow-sm h-100 border-0" style="border: 1px solid #ddd;">
                            <div class="ratio ratio-1x1 bg-light">
                                @if($rp->image)
                                    <img src="{{ asset('storage/'.$rp->image) }}"
                                         alt="{{ $rp->name }}"
                                         class="w-100 h-100 object-fit-cover">
                                @else
                                    <div class="d-flex justify-content-center align-items-center text-secondary fw-semibold">
                                        Photo here
                                    </div>
                                @endif
                            </div>
                            <div class="card-body text-center d-flex flex-column">
                                <h6 class="fw-bold mb-1">{{ $rp->name }}</h6>
                                <p class="text-muted small mb-1">
                                    {{ $rp->category->name ?? 'No Category' }}
                                </p>
                            @php
                                $hasDiscount = $rp->discount_percent > 0;
                                $finalPrice  = $hasDiscount
                                    ? $rp->price - intval($rp->price * $rp->discount_percent / 100)
                                    : $rp->price;
                            @endphp

                            @if($hasDiscount)
                                <p class="mb-1">
                                    <span class="text-muted text-decoration-line-through">
                                        Rp {{ number_format($rp->price,0,',','.') }}
                                    </span>
                                    <span class="badge bg-danger ms-1">-{{ $rp->discount_percent }}%</span>
                                </p>
                            @endif

                            <p class="fw-bold mb-2" style="color:#5b0b18;">
                                Rp {{ number_format($finalPrice,0,',','.') }}
                            </p>

                                <a href="{{ route('products.show', $rp->id) }}"
                                   class="btn btn-sm btn-dark mt-auto">
                                    View
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-3">

        @foreach($products as $p)
            @php
                $qtyInCart  = $cartItemsByProduct[$p->id] ?? 0;
                $outOfStock = $p->stock <= 0;
            @endphp

            <div class="col">
                <div class="card shadow-sm h-100 d-flex flex-column border-0"
                     style="border: 1px solid #ddd;">

                    <div class="ratio ratio-1x1 bg-light">
                        @if($p->image)
                            <img src="{{ asset('storage/'.$p->image) }}"
                                 alt="{{ $p->name }}"
                                 class="w-100 h-100 object-fit-cover">
                        @else
                            <div class="d-flex justify-content-center align-items-center text-secondary fw-semibold">
                                Photo here
                            </div>
                        @endif
                    </div>

                    <div class="card-body d-flex flex-column text-center">

                        <h5 class="card-title fw-bold text-dark mb-1">
                            {{ $p->name }}
                            @auth
                                @if(in_array($p->id, $wishlistProductIds ?? []))
                                    <span style="color:#c2183f;">♥</span>
                                @endif
                            @endauth
                        </h5>

                        <div class="d-flex justify-content-center mb-1">
                            <div style="border-bottom: 2px solid #eee; width: 70%;"></div>
                        </div>
                        <p class="text-uppercase text-muted small mb-2" style="letter-spacing: 1px;">
                            {{ $p->category->name ?? 'No Category' }}
                        </p>

                        <p class="text-secondary flex-grow-1 mb-2" style="font-size: 0.9rem;">
                            {{ \Illuminate\Support\Str::limit($p->description, 70) }}
                        </p>

                        @php
                            $hasDiscount = $p->discount_percent > 0;
                            $finalPrice  = $hasDiscount
                                ? $p->price - intval($p->price * $p->discount_percent / 100)
                                : $p->price;
                        @endphp

                        @if($hasDiscount)
                            <p class="mb-1">
                                <span class="text-muted text-decoration-line-through">
                                    Rp {{ number_format($p->price,0,',','.') }}
                                </span>
                                <span class="badge bg-danger ms-1">-{{ $p->discount_percent }}%</span>
                            </p>
                        @endif

                        <p class="fw-bold mb-1" style="color:#5b0b18;">
                            Rp {{ number_format($finalPrice,0,',','.') }}
                        </p>

                        <p class="text-muted mb-1" style="font-size: 0.9rem;">
                            Stock:
                            @if($outOfStock)
                                <span class="text-danger fw-bold">0 (Out of stock)</span>
                            @else
                                <strong>{{ $p->stock }}</strong>
                            @endif
                        </p>

                        {{-- sold yg kliatan atmin aja --}}
                        @auth
                            @if(auth()->user()->isAdmin())
                                <p class="text-muted mb-2" style="font-size: 0.9rem;">
                                    Sold: <strong>{{ $p->order_items_sum_quantity ?? 0 }}</strong> item(s)
                                </p>
                            @endif
                        @endauth>

                        <div class="d-flex flex-column gap-2 mt-auto">

                            <div class="d-flex gap-2 justify-content-center">
                                <a href="{{ route('products.show', $p->id) }}"
                                   class="btn btn-sm btn-dark btn-elevated">
                                    Detail
                                </a>

                                @auth
                                    @if(auth()->user()->isAdmin())
                                        <a href="{{ route('products.edit', $p->id) }}"
                                           class="btn btn-sm btn-pink btn-elevated">
                                            Edit
                                        </a>

                                        <form action="{{ route('products.delete', $p->id) }}"
                                              method="POST"
                                              onsubmit="return confirm('Delete this product?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="btn btn-sm btn-outline-danger"
                                                    title="Delete product">
                                                🗑
                                            </button>
                                        </form>
                                    @endif
                                @endauth
                            </div>

                            @auth
                                @if(!auth()->user()->isAdmin())

                                    @if($outOfStock)
                                        <span class="badge bg-secondary mt-1">
                                            Out of stock
                                        </span>
                                    @else
                                        {{-- + apdet cart --}}
                                        @if($qtyInCart <= 0)
                                            <form method="POST"
                                                  action="{{ route('cart.add', $p->id) }}"
                                                  class="mt-1">
                                                @csrf
                                                <input type="hidden" name="quantity" value="1">
                                                <button class="btn btn-sm btn-outline-dark d-flex align-items-center justify-content-center w-100">
                                                    <span class="me-1">🛒</span> Add to Cart
                                                </button>
                                            </form>
                                        @else
                                            <form method="POST"
                                                  action="{{ route('cart.add', $p->id) }}"
                                                  class="d-flex align-items-center justify-content-center gap-2 mt-1">
                                                @csrf
                                                <div class="input-group input-group-sm" style="width:110px;">
                                                    <button class="btn btn-outline-secondary" type="button"
                                                            onclick="this.parentElement.querySelector('input').stepDown()">
                                                        –
                                                    </button>
                                                    <input type="number"
                                                           name="quantity"
                                                           class="form-control text-center"
                                                           value="{{ $qtyInCart }}"
                                                           min="0"
                                                           max="{{ $p->stock }}">
                                                    <button class="btn btn-outline-secondary" type="button"
                                                            onclick="this.parentElement.querySelector('input').stepUp()">
                                                        +
                                                    </button>
                                                </div>
                                                <button type="submit"
                                                        class="btn btn-sm btn-outline-danger d-flex align-items-center"
                                                        style="border-color:#5b0b18; color:#5b0b18;">
                                                    <span class="me-1">🛒</span> Update
                                                </button>
                                            </form>
                                        @endif

                                        <form method="POST" action="{{ route('wishlist.store', $p->id) }}" class="mt-1">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-outline-secondary w-100">
                                                ♥ Wishlist
                                            </button>
                                        </form>

                                        <a href="{{ route('products.buyNow', $p->id) }}"
                                           class="btn btn-sm btn-pink btn-elevated mt-1">
                                            Buy Now
                                        </a>
                                    @endif

                                @endif
                            @endauth

                        </div>

                    </div>
                </div>
            </div>
        @endforeach

    </div>

    <div class="mt-4 d-flex justify-content-center">
        {{ $products->links() }}
    </div>

</x-layout>
