<x-layout>
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h3 class="mb-0" style="color:#5b0b18;">Manage Products</h3>
            <small class="text-muted">Upload menu, edit, delete, manage stock & discount.</small>
        </div>
        <a href="{{ route('admin.products.create') }}" class="btn btn-pink btn-elevated">
            + Add New Product
        </a>
    </div>

    @if(session('success'))
        <div class="alert-maroon d-flex align-items-center mb-3">
            <span class="alert-icon">✅</span>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <div class="card shadow-sm border-0 rounded-4">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="table-light">
                <tr>
                    <th>Product</th>
                    <th>Category</th>
                    <th class="text-end" style="width:120px;">Price</th>
                    <th class="text-center" style="width:90px;">Stock</th>
                    <th class="text-center" style="width:110px;">Discount</th>
                    <th class="text-end" style="width:120px;">Final Price</th>
                    <th class="text-end" style="width:140px;">Actions</th>
                </tr>
                </thead>
                <tbody>
                @forelse($products as $p)
                    <tr>
                        <td>{{ $p->name }}</td>
                        <td>{{ $p->category->name ?? '-' }}</td>
                        <td class="text-end">Rp {{ number_format($p->price, 0, ',', '.') }}</td>
                        <td class="text-center">{{ $p->stock }}</td>
                        <td class="text-center">{{ $p->discount_percent }}%</td>
                        <td class="text-end">Rp {{ number_format($p->final_price, 0, ',', '.') }}</td>
                        <td class="text-end">
                            <a href="{{ route('admin.products.edit', $p->id) }}"
                               class="btn btn-sm btn-outline-secondary">
                                Edit
                            </a>
                            <form method="POST"
                                  action="{{ route('admin.products.destroy', $p->id) }}"
                                  class="d-inline"
                                  onsubmit="return confirm('Delete this product?');">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">
                            No products yet. Click “Add New Product”.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="card-footer border-0">
            <div class="d-flex justify-content-center">
                {{ $products->links() }}
            </div>
        </div>
    </div>
</x-layout>
