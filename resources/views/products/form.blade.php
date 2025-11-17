
<x-layout>

    <h3 class="mb-4">{{ isset($product) ? 'Edit Product' : 'Add Product' }}</h3>

    <form method="POST" action="{{ isset($product) ? route('products.update', $product['id']) : route('products.store') }}">
        @csrf

        <div class="mb-3">
            <label class="form-label">Product Name</label>
            <input type="text" name="name" class="form-control"
                   value="{{ $product['name'] ?? '' }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control" rows="3">{{ $product['description'] ?? '' }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Price</label>
            <input type="number" name="price" class="form-control"
                   value="{{ $product['price'] ?? '' }}">
        </div>

        <button class="btn btn-pink">Submit</button>
    </form>

</x-layout>
