<x-layout>

    <h3 class="mb-4">Your Cart</h3>

    @if(session('success'))
        <div class="alert-maroon d-flex align-items-center mb-3">
            <span class="alert-icon">✅</span>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div class="alert-maroon d-flex align-items-center mb-3"
             style="background-color:#fce8eb; border-color:#f3b6c2; color:#7b1024;">
            <span class="alert-icon">⚠️</span>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    @if($cart->items->count() === 0)
        <div class="alert-maroon d-flex align-items-center mb-3">
            <span class="alert-icon">ℹ️</span>
            <span>
                Your cart is empty. Go back to
                <a href="{{ route('products.index') }}" class="link-maroon text-decoration-underline">
                    products
                </a>
                to add some drinks.
            </span>
        </div>
    @else
        <div class="table-responsive mb-3">
            <table class="table align-middle">
                <thead>
                <tr>
                    <th>Product</th>
                    <th width="120">Price</th>
                    <th width="180">Quantity</th>
                    <th width="140">Subtotal</th>
                    <th width="80"></th>
                </tr>
                </thead>
                <tbody>
                @foreach($cart->items as $item)
                    <tr>
                        <td>
                            <strong>{{ $item->name }}</strong><br>
                            <small class="text-muted">
                                {{ $item->product->category->name ?? '-' }}
                            </small>
                        </td>
                        <td>
                            Rp {{ number_format($item->price, 0, ',', '.') }}
                        </td>
                        <td>
                            <form method="POST" action="{{ route('cart.update', $item->id) }}"
                                  class="d-flex align-items-center">
                                @csrf
                                <div class="input-group input-group-sm">
                                    <button class="btn btn-outline-secondary" type="button"
                                            onclick="let i=this.parentElement.querySelector('input'); i.stepDown(); this.form.submit();">
                                        –
                                    </button>
                                    <input type="number" name="quantity"
                                           class="form-control text-center"
                                           value="{{ $item->quantity }}" min="1"
                                           onchange="this.form.submit()">
                                    <button class="btn btn-outline-secondary" type="button"
                                            onclick="let i=this.parentElement.querySelector('input'); i.stepUp(); this.form.submit();">
                                        +
                                    </button>
                                </div>
                            </form>
                        </td>
                        <td>
                            Rp {{ number_format($item->quantity * $item->price, 0, ',', '.') }}
                        </td>
                        <td>
                            <form method="POST" action="{{ route('cart.remove', $item->id) }}">
                                @csrf
                                <button class="btn btn-sm btn-outline-danger">
                                    ×
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
                <tfoot>
                <tr>
                    <th colspan="3" class="text-end">Total</th>
                    <th colspan="2">
                        Rp {{ number_format($cart->total, 0, ',', '.') }}
                    </th>
                </tr>
                </tfoot>
            </table>
        </div>

        <div class="d-flex justify-content-between align-items-center">
            <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">
                ← Continue Shopping
            </a>

            <a href="{{ route('checkout.form') }}" class="btn btn-pink fw-bold">
                Proceed to Checkout
            </a>
        </div>
    @endif

</x-layout>
