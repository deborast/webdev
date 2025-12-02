<x-layout>

    <h3 class="mb-4">{{ isset($product) ? 'Edit Product' : 'Add Product' }}</h3>

    <form method="POST" action="{{ isset($product)
        ? route('products.update', $product->id)
        : route('products.store') }}">
        @csrf

        <div class="mb-3">
            <label class="form-label">Category</label>
            <select name="category_id" class="form-select">
                <option value="">-- Choose category --</option>
                @foreach($categories as $c)
                    <option value="{{ $c->id }}"
                        {{ isset($product) && $product->category_id == $c->id ? 'selected' : '' }}>
                        {{ $c->name }}
                    </option>
                @endforeach
            </select>
            @error('category_id')
            <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Product Name</label>
            <input type="text" name="name" class="form-control"
                   value="{{ old('name', $product->name ?? '') }}">
            @error('name')
            <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control" rows="3">{{ old('description', $product->description ?? '') }}</textarea>
            @error('description')
            <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Price</label>
            <input type="number" name="price" class="form-control"
                   value="{{ old('price', $product->price ?? '') }}">
            @error('price')
            <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>

        <button class="btn btn-pink">Submit</button>
    </form>

</x-layout>
