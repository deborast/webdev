<x-layout>
    <h3 class="mb-3">Manage Categories</h3>

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

    <div class="mb-3 text-end">
        <a href="{{ route('categories.create') }}" class="btn btn-pink btn-elevated">
            + Add Category
        </a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            @if($categories->isEmpty())
                <p class="mb-0 text-muted">No categories yet.</p>
            @else
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead>
                        <tr>
                            <th style="width:80px;">ID</th>
                            <th>Name</th>
                            <th style="width:200px;" class="text-end">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($categories as $category)
                            <tr>
                                <td>{{ $category->id }}</td>
                                <td>{{ $category->name }}</td>
                                <td class="text-end d-flex justify-content-end gap-2">
                                    <a href="{{ route('categories.edit', $category) }}"
                                       class="btn btn-sm btn-pink">
                                        Edit
                                    </a>
                                    <form action="{{ route('categories.destroy', $category) }}"
                                          method="POST"
                                          onsubmit="return confirm('Delete this category?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="btn btn-sm btn-outline-danger">
                                            🗑
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-3 d-flex justify-content-center">
                    {{ $categories->links() }}
                </div>
            @endif
        </div>
    </div>
</x-layout>
