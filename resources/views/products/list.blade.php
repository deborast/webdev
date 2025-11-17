<x-layout>

    <a href="{{ route('products.create') }}" class="btn btn-warning mb-3 text-dark fw-bold">
        Add new product
    </a>

    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-3">

        @foreach($products as $p)
        <div class="col">

            <div class="card shadow-sm h-100 d-flex flex-column border-0"
                 style="border: 1px solid #ff8800;">

                <div class="card-body d-flex flex-column">

                    <h5 class="card-title fw-bold text-dark">{{ $p['name'] }}</h5>

                    <p class="text-secondary flex-grow-1">
                        {{ $p['description'] }}
                    </p>

                    <p class="fw-bold" style="color:#ff8800;">
                        Rp {{ number_format($p['price'],0,',','.') }}
                    </p>

                    <div class="d-flex gap-2 mt-3">

                        <a href="{{ route('products.show', $p['id']) }}"
                           class="btn btn-sm btn-dark btn-dark-orange-hover">
                           Detail
                        </a>

                        <a href="{{ route('products.edit', $p['id']) }}"
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
