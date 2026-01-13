<x-layout>
    <h3 class="mb-4">
        {{ $category->exists ? 'Edit Category' : 'Add Category' }}
    </h3>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <form
                method="POST"
                action="{{ $category->exists
                            ? route('categories.update', $category)
                            : route('categories.store') }}"
            >
                @csrf
                @if($category->exists)
                    @method('PUT')
                @endif

                <div class="mb-3">
                    <label class="form-label">Category Name</label>
                    <input type="text"
                           name="name"
                           class="form-control"
                           value="{{ old('name', $category->name) }}"
                           required>
                    @error('name')
                    <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <button class="btn btn-pink">
                    {{ $category->exists ? 'Update' : 'Create' }}
                </button>
                <a href="{{ route('categories.index') }}" class="btn btn-outline-secondary ms-2">
                    Cancel
                </a>
            </form>
        </div>
    </div>
</x-layout>
