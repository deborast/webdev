<x-layout>

    <h3 class="mb-4">Checkout</h3>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="row">
        <div class="col-md-7 mb-4">
            <div class="card shadow-sm border-0 mb-3">
                <div class="card-body">
                    <h5 class="card-title mb-3">Shipping & Payment</h5>

                    <form method="POST" action="{{ route('checkout.process') }}">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Full Name</label>
                            <input type="text" name="full_name" class="form-control"
                                   value="{{ old('full_name') }}">
                            @error('full_name')
                            <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Phone Number</label>
                            <input type="text" name="phone" class="form-control"
                                   value="{{ old('phone') }}">
                            @error('phone')
                            <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Address</label>
                            <input type="text" name="address_line" class="form-control"
                                   value="{{ old('address_line') }}">
                            @error('address_line')
                            <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Province</label>
                                <input type="text" name="province" class="form-control"
                                       value="{{ old('province') }}">
                                @error('province')
                                <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">City</label>
                                <input type="text" name="city" class="form-control"
                                       value="{{ old('city') }}">
                                @error('city')
                                <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Postal Code</label>
                            <input type="text" name="postal_code" class="form-control"
                                   value="{{ old('postal_code') }}">
                            @error('postal_code')
                            <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Payment Method</label>
                            <select name="payment_method" class="form-select">
                                <option value="">-- Choose method --</option>
                                <option value="Cash" {{ old('payment_method') == 'Cash' ? 'selected' : '' }}>Cash</option>
                                <option value="Bank Transfer" {{ old('payment_method') == 'Bank Transfer' ? 'selected' : '' }}>Bank Transfer</option>
                                <option value="E-Wallet" {{ old('payment_method') == 'E-Wallet' ? 'selected' : '' }}>E-Wallet</option>
                            </select>
                            @error('payment_method')
                            <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-pink fw-bold">
                            Place Order
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-5">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h5 class="card-title mb-3">Order Summary</h5>

                    <ul class="list-group list-group-flush mb-3">
                        @foreach($cart->items as $item)
                            <li class="list-group-item d-flex justify-content-between">
                                <div>
                                    <strong>{{ $item->name }}</strong><br>
                                    <small class="text-muted">
                                        x {{ $item->quantity }}
                                    </small>
                                </div>
                                <div>
                                    Rp {{ number_format($item->quantity * $item->price, 0, ',', '.') }}
                                </div>
                            </li>
                        @endforeach
                    </ul>

                    <div class="d-flex justify-content-between">
                        <strong>Total</strong>
                        <strong>Rp {{ number_format($cart->total, 0, ',', '.') }}</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-layout>
