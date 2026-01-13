{{-- resources/views/products/form.blade.php --}}
<x-layout>

    <h3 class="mb-4">
        {{ isset($product) ? 'Edit Product' : 'Add Product' }}
    </h3>

    <form method="POST"
          action="{{ isset($product)
                    ? route('products.update', $product->id)
                    : route('products.store') }}"
          enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label class="form-label">Category</label>
            <select name="category_id" class="form-select">
                <option value="">-- Choose category --</option>
                @foreach($categories as $c)
                    <option value="{{ $c->id }}"
                        {{ old('category_id', $product->category_id ?? '') == $c->id ? 'selected' : '' }}>
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
            <textarea name="description" class="form-control" rows="3">
                {{ old('description', $product->description ?? '') }}
            </textarea>
            @error('description')
            <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Product Image</label>
            <input type="file" name="image" class="form-control">
            @if(!empty($product?->image))
                <div class="mt-2">
                    <img src="{{ asset('storage/'.$product->image) }}"
                         alt="Current image"
                         style="max-height:120px;">
                </div>
            @endif
            @error('image')
            <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>

        <div class="row">
            <div class="col-md-4 mb-3">
                <label class="form-label">Price (Rp)</label>
                <input type="number" name="price" class="form-control"
                       value="{{ old('price', $product->price ?? '') }}">
                @error('price')
                <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label">Stock</label>
                <input type="number" name="stock" class="form-control"
                       value="{{ old('stock', $product->stock ?? 0) }}">
                @error('stock')
                <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label">Discount (%)</label>
                <input type="number" name="discount_percent" class="form-control"
                       value="{{ old('discount_percent', $product->discount_percent ?? 0) }}"
                       min="0" max="100">
                @error('discount_percent')
                <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <button class="btn btn-pink">Save Product</button>
    </form>

</x-layout>
