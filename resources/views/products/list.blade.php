<x-layout>

    @if(session('success'))
        <div class="alert alert-maroon d-flex align-items-center mb-3">
            <span class="alert-icon">✅</span>
            <span>{{ session('success') }}</span>
        </div>
    @endif

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
                                        <option value="name" {{ request('sort_by') == 'name' ? 'selected' : '' }}>Name</option>
                                        <option value="price" {{ request('sort_by') == 'price' ? 'selected' : '' }}>Price</option>
                                    </select>
                                </div>

                                <div class="mb-2">
                                    <label class="form-label">Order</label>
                                    <select name="sort_dir" class="form-select form-select-sm">
                                        <option value="asc" {{ request('sort_dir') == 'asc' ? 'selected' : '' }}>Ascending</option>
                                        <option value="desc" {{ request('sort_dir') == 'desc' ? 'selected' : '' }}>Descending</option>
                                    </select>
                                </div>

                                <button class="btn btn-sm btn-pink w-100 mt-1">Apply Filter</button>
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

    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-3">

        @foreach($products as $p)
        <div class="col">

            <div class="card shadow-sm h-100 d-flex flex-column border-0"
                 style="border: 1px solid #ddd;">

                <div class="ratio ratio-4x3 bg-light">
                    <div class="d-flex justify-content-center align-items-center text-secondary fw-semibold">
                        Photo here
                    </div>
                </div>

                <div class="card-body d-flex flex-column text-center">

                    <h5 class="card-title fw-bold text-dark mb-1">
                        {{ $p->name }}
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

                    <p class="fw-bold mb-2" style="color:#5b0b18;">
                        Rp {{ number_format($p->price,0,',','.') }}
                    </p>

                    <div class="d-flex flex-column gap-2 mt-auto">
                        <div class="d-flex gap-2 justify-content-center">
                            <a href="{{ route('products.show', $p->id) }}"
                               class="btn btn-sm btn-dark btn-elevated">
                                Detail
                            </a>

                            <a href="{{ route('products.edit', $p->id) }}"
                               class="btn btn-sm btn-pink btn-elevated">
                                Edit
                            </a>
                        </div>

                        @auth
                            @php
                                $qtyInCart = $cartItemsByProduct[$p->id] ?? 0;
                            @endphp

                            @if($qtyInCart <= 0)
                                <form method="POST" action="{{ route('cart.add', $p->id) }}" class="mt-1">
                                    @csrf
                                    <button class="btn btn-sm btn-outline-dark d-flex align-items-center justify-content-center w-100">
                                        <span class="me-1">🛒</span> Add to Cart
                                    </button>
                                </form>
                            @else
                                <form method="POST" action="{{ route('cart.add', $p->id) }}"
                                      class="d-flex align-items-center justify-content-center gap-2 mt-1">
                                    @csrf
                                    <div class="input-group input-group-sm" style="width:110px;">
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
                                    <button class="btn btn-sm btn-outline-danger custom-update d-flex align-items-center"
                                            style="border-color:#5b0b18; color:#5b0b18;">
                                        <span class="me-1">🛒</span> Update
                                    </button>
                                </form>
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
