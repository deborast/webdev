<x-layout>

    <h3 class="mb-4">Your Orders</h3>

    @if(session('success'))
        <div class="alert-maroon d-flex align-items-center mb-3">
            <span class="alert-icon">✅</span>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if ($orders->isEmpty())
        <div class="alert-maroon d-flex align-items-center justify-content-center">
            <span class="alert-icon">☕</span>
            <span>You have not placed any orders yet. Start by adding products to your cart.</span>
        </div>
    @else
        <div class="d-flex flex-column gap-3">
            @foreach($orders as $order)
                <div class="card border-0 shadow-sm rounded-4 order-card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <div class="d-flex align-items-center gap-2 mb-1">
                                    <span class="badge bg-dark rounded-pill">
                                        #{{ $order->id }}
                                    </span>
                                    <strong>Order</strong>
                                </div>

                                <small class="text-muted d-block mb-1">
                                    {{ $order->created_at->format('d M Y H:i') }} • {{ $order->payment_method }}
                                </small>

                                <span class="badge bg-success-subtle text-success border border-success-subtle">
                                    Completed
                                </span>
                            </div>

                            <div class="text-end">
                                <div class="fw-bold mb-1" style="color:#5b0b18;">
                                    Rp {{ number_format($order->total, 0, ',', '.') }}
                                </div>
                                <small class="text-muted d-block">
                                    {{ Str::limit($order->shipping_address, 50) }}
                                </small>
                            </div>
                        </div>

                        <hr class="my-3">

                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center gap-2 text-muted">
                                <span>📦</span>
                                <small>
                                    {{ $order->items->count() }} item(s)
                                </small>
                            </div>

                            <a href="{{ route('orders.show', $order->id) }}"
                               class="btn btn-sm btn-pink">
                                View details →
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-3 d-flex justify-content-center">
            {{ $orders->links() }}
        </div>
    @endif

</x-layout>
