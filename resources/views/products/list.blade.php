<x-layout>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form method="GET" action="{{ route('products.index') }}" class="mb-4">
        <div class="row g-2 align-items-end">

            <div class="col-md-3">
                <label class="form-label">Search</label>
                <input type="text" name="q" class="form-control"
                       value="{{ request('q') }}" placeholder="Name or description">
            </div>

            <div class="col-md-2">
                <label class="form-label">Min Price</label>
                <input type="number" name="min_price" class="form-control"
                       value="{{ request('min_price') }}">
            </div>

            <div class="col-md-2">
                <label class="form-label">Max Price</label>
                <input type="number" name="max_price" class="form-control"
                       value="{{ request('max_price') }}">
            </div>

            <div class="col-md-2">
                <label class="form-label">Sort By</label>
                <select name="sort_by" class="form-select">
                    <option value="name" {{ request('sort_by') == 'name' ? 'selected' : '' }}>Name</option>
                    <option value="price" {{ request('sort_by') == 'price' ? 'selected' : '' }}>Price</option>
                </select>
            </div>

            <div class="col-md-2">
                <label class="form-label">Order</label>
                <select name="sort_dir" class="form-select">
                    <option value="asc" {{ request('sort_dir') == 'asc' ? 'selected' : '' }}>Ascending</option>
                    <option value="desc" {{ request('sort_dir') == 'desc' ? 'selected' : '' }}>Descending</option>
                </select>
            </div>

            <div class="col-md-1">
                <button class="btn btn-pink w-100">Go</button>
            </div>
        </div>
    </form>


    <div class="mb-3 d-flex align-items-center flex-wrap gap-2">
        <strong class="me-2">Categories:</strong>

        <a href="{{ route('products.index', array_merge(request()->except('page','category_id'))) }}"
           class="text-decoration-none">
            <span class="badge rounded-pill px-3 py-2
                {{ empty($currentCategoryId) ? 'bg-dark text-white' : 'bg-light text-dark border' }}">
                All
            </span>
        </a>

        @foreach($categories as $c)
            <a href="{{ route('products.index', array_merge(request()->except('page'), ['category_id' => $c->id])) }}"
               class="text-decoration-none">
                <span class="badge rounded-pill px-3 py-2
                    {{ (string)$currentCategoryId === (string)$c->id
                        ? 'bg-warning text-dark'
                        : 'bg-white text-dark border' }}">
                    {{ $c->name }}
                </span>
            </a>
        @endforeach
    </div>

    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-3">

        @foreach($products as $p)
        <div class="col">

            <div class="card shadow-sm h-100 d-flex flex-column border-0"
                 style="border: 1px solid #ff8800;">

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
                        <div style="border-bottom: 2px solid #ffe0b5; width: 70%;"></div>
                    </div>
                    <p class="text-uppercase text-muted small mb-2" style="letter-spacing: 1px;">
                        {{ $p->category->name ?? 'No Category' }}
                    </p>

                    <p class="text-secondary flex-grow-1 mb-2" style="font-size: 0.9rem;">
                        {{ \Illuminate\Support\Str::limit($p->description, 70) }}
                    </p>

                    <p class="fw-bold mb-2" style="color:#ff8800;">
                        Rp {{ number_format($p->price,0,',','.') }}
                    </p>

                    <div class="d-flex gap-2 mt-auto justify-content-center">
                        <a href="{{ route('products.show', $p->id) }}"
                           class="btn btn-sm btn-dark">
                           Detail
                        </a>

                        <a href="{{ route('products.edit', $p->id) }}"
                           class="btn btn-sm btn-pink">
                           Edit
                        </a>
                    </div>

                </div>
            </div>
        </div>
        @endforeach

    </div>

</x-layout>
