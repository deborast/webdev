<x-layout>
    <div class="row justify-content-center mt-4">
        <div class="col-md-8 col-lg-6">

            <div class="card shadow-sm border-0 rounded-4" style="border: 1px solid #f3d4da;">
                <div class="card-body">

                    <h2 class="fw-bold text-dark mb-2 text-center">
                        Order #{{ $order->id }}
                    </h2>
                    <p class="text-center text-muted mb-3">
                        Date: {{ $order->created_at->format('d M Y H:i') }}
                    </p>

                    @php
                        $pointsUsed = (int)($order->points_used ?? 0);
                        $subtotal   = (int)($order->subtotal_before_discount ?? $order->total);
                        $pointsDisc = intdiv($pointsUsed, 100) * 10000;
                    @endphp

                    <div class="row mb-3">
                        <div class="col-md-4 mb-3 mb-md-0">
                            <h6 class="fw-bold mb-1">Payment Method</h6>
                            <p class="mb-0">{{ $order->payment_method }}</p>
                        </div>

                        <div class="col-md-4 mb-3 mb-md-0">
                            <h6 class="fw-bold mb-1">Points Used</h6>
                            <p class="mb-0">
                                {{ $pointsUsed }} pts
                            </p>
                            @if($pointsUsed > 0)
                                <small class="text-muted d-block">
                                    Discount: Rp {{ number_format($pointsDisc, 0, ',', '.') }}
                                </small>
                            @endif
                        </div>

                        <div class="col-md-4 text-md-end">
                            <h6 class="fw-bold mb-1">Total</h6>
                            <p class="mb-0 fw-bold fs-4" style="color:#5b0b18;">
                                Rp {{ number_format($order->total, 0, ',', '.') }}
                            </p>
                            @if($pointsUsed > 0)
                                <small class="text-muted d-block">
                                    Before discount: Rp {{ number_format($subtotal, 0, ',', '.') }}
                                </small>
                            @endif
                        </div>
                    </div>

                    <div class="mb-3">
                        <h6 class="fw-bold">Shipping Address</h6>
                        <pre class="mb-0" style="white-space:pre-wrap; font-family:inherit;">
{{ $order->shipping_address }}
                        </pre>
                    </div>

                    <div class="mb-3">
                        <h6 class="fw-bold mb-2">Items</h6>

                        <div class="table-responsive">
                            <table class="table table-sm align-middle">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th class="text-end">Price</th>
                                        <th class="text-center">Qty</th>
                                        <th class="text-end">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($order->items as $item)
                                        <tr>
                                            <td>
                                                {{ $item->name }}
                                                @if($item->product && $item->product->image)
                                                    <div class="mt-1">
                                                        <img src="{{ asset('storage/'.$item->product->image) }}"
                                                             alt="{{ $item->name }}"
                                                             style="width:50px; height:50px; object-fit:cover; border-radius:6px;">
                                                    </div>
                                                @endif
                                            </td>
                                            <td class="text-end">
                                                Rp {{ number_format($item->price, 0, ',', '.') }}
                                            </td>
                                            <td class="text-center">
                                                {{ $item->quantity }}
                                            </td>
                                            <td class="text-end">
                                                Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="3" class="text-end">Subtotal</th>
                                        <th class="text-end">
                                            Rp {{ number_format($subtotal, 0, ',', '.') }}
                                        </th>
                                    </tr>
                                    @if($pointsUsed > 0)
                                        <tr>
                                            <th colspan="3" class="text-end">
                                                Points used ({{ $pointsUsed }} pts)
                                            </th>
                                            <th class="text-end text-success">
                                                - Rp {{ number_format($pointsDisc, 0, ',', '.') }}
                                            </th>
                                        </tr>
                                    @endif
                                    <tr>
                                        <th colspan="3" class="text-end">Total</th>
                                        <th class="text-end" style="color:#5b0b18;">
                                            Rp {{ number_format($order->total, 0, ',', '.') }}
                                        </th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('orders.index') }}" class="btn btn-sm btn-secondary">
                            ← Back to Orders
                        </a>
                        <a href="{{ route('products.index') }}" class="btn btn-sm btn-dark">
                            Browse Products
                        </a>
                    </div>

                </div>
            </div>

        </div>
    </div>
</x-layout>
