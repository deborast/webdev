<x-layout>

    <div class="row justify-content-center mt-4">
        <div class="col-lg-8">

            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <h3 class="mb-1">Order #{{ $order->id }}</h3>
                    <small class="text-muted">
                        {{ $order->created_at->format('d M Y H:i') }} • {{ $order->payment_method }}
                    </small>
                </div>
                <span class="badge bg-success-subtle text-success border border-success-subtle">
                    Completed
                </span>
            </div>

            <div class="card shadow-sm border-0 rounded-4 mb-4" style="border:1px solid #f3d4da;">
                <div class="card-body">

                    <div class="row mb-3">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <h6 class="text-uppercase text-muted mb-1" style="letter-spacing: .08em;">
                                Payment
                            </h6>
                            <p class="mb-0 fw-semibold">{{ $order->payment_method }}</p>
                        </div>
                        <div class="col-md-6 text-md-end">
                            <h6 class="text-uppercase text-muted mb-1" style="letter-spacing: .08em;">
                                Total
                            </h6>
                            <p class="mb-0 fw-bold fs-4" style="color:#5b0b18;">
                                Rp {{ number_format($order->total, 0, ',', '.') }}
                            </p>
                        </div>
                    </div>

                    <hr class="my-3">

                    <div class="mb-2">
                        <h6 class="text-uppercase text-muted mb-1" style="letter-spacing: .08em;">
                            Shipping Address
                        </h6>
                        <pre class="mb-0" style="white-space:pre-wrap; font-family:inherit;">
{{ $order->shipping_address }}
                        </pre>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body">
                    <h5 class="mb-3">Items</h5>

                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead class="table-light">
                            <tr>
                                <th>Product</th>
                                <th class="text-end" style="width:120px;">Price</th>
                                <th class="text-center" style="width:80px;">Qty</th>
                                <th class="text-end" style="width:140px;">Subtotal</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($order->items as $item)
                                <tr>
                                    <td>{{ $item->name }}</td>
                                    <td class="text-end">
                                        Rp {{ number_format($item->price, 0, ',', '.') }}
                                    </td>
                                    <td class="text-center">{{ $item->quantity }}</td>
                                    <td class="text-end">
                                        Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
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
            </div>

            <div class="mt-4">
                <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary">
                    ← Back to Orders
                </a>
            </div>

        </div>
    </div>

</x-layout>
