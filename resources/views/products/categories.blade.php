<x-layout>

    <div class="mb-4">
        <h3 style="color:#5b0b18;">Choose Category</h3>
        <p class="text-muted mb-0">
            Pick a category to explore our menu.
        </p>
    </div>

    <div class="row g-3 mb-3">
        <div class="col-6 col-md-4 col-lg-3">
            <a href="{{ route('products.index') }}" class="text-decoration-none">
                <div class="card h-100 border-0 shadow-sm rounded-4 text-center py-4 hover-shadow"
                     style="background-color:#fce8eb; color:#5b0b18;">
                    <div class="fs-3 mb-2">☕</div>
                    <div class="fw-semibold">All Menu</div>
                    <div class="small text-muted mt-1">
                        See everything in one place.
                    </div>
                </div>
            </a>
        </div>

        @foreach($categories as $category)
            <div class="col-6 col-md-4 col-lg-3">
                <a href="{{ route('products.index', ['category_id' => $category->id]) }}"
                   class="text-decoration-none text-dark">
                    <div class="card h-100 border-0 shadow-sm rounded-4 text-center py-4 hover-shadow">
                        <div class="fs-3 mb-2">
                            @switch($category->name)
                                @case('Coffee') ☕ @break
                                @case('Matcha') 🍵 @break
                                @case('Milky Way') 🌌 @break
                                @case('Tea') 🫖 @break
                                @case('Summer') 🌞 @break
                                @case('Kombucha') 🧋 @break
                                @case('Paasta') 🍝 @break
                                @case('Platter') 🍽️ @break
                                @case('Snack') 🍟 @break
                                @case('Local Food') 🍲 @break
                                @case('Rice Bowl') 🍛 @break
                                @default 🍹
                            @endswitch
                        </div>
                        <div class="fw-semibold" style="color:#5b0b18;">
                            {{ $category->name }}
                        </div>
                        <div class="small text-muted mt-1">
                            Tap to see drinks & food.
                        </div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>

</x-layout>
