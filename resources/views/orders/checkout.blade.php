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

                    @if(isset($addresses) && $addresses->count() > 0)
                        <div class="mb-3">
                            <label class="form-label">Choose saved address</label>
                            <select id="saved-address" class="form-select">
                                <option value="">-- Do not use saved address --</option>
                                @foreach($addresses as $addr)
                                    <option value="{{ $addr->id }}"
                                            data-full_name="{{ $addr->full_name }}"
                                            data-phone="{{ $addr->phone }}"
                                            data-address_line="{{ $addr->address_line }}"
                                            data-city="{{ $addr->city }}"
                                            data-province="{{ $addr->province }}"
                                            data-postal_code="{{ $addr->postal_code }}">
                                        {{ $addr->full_name }} - {{ $addr->city }}, {{ $addr->province }}
                                    </option>
                                @endforeach
                            </select>
                            <small class="text-muted">Selecting an address will fill the form below.</small>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('checkout.process') }}" id="checkout-form">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Full Name</label>
                            <input type="text" name="full_name" id="full_name" class="form-control"
                                   value="{{ old('full_name') }}">
                            @error('full_name')
                            <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Phone Number</label>
                            <input type="text" name="phone" id="phone" class="form-control"
                                   value="{{ old('phone') }}">
                            @error('phone')
                            <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Address</label>
                            <input type="text" name="address_line" id="address_line" class="form-control"
                                   value="{{ old('address_line') }}">
                            @error('address_line')
                            <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Province</label>
                                <input type="text" name="province" id="province" class="form-control"
                                       value="{{ old('province') }}">
                                @error('province')
                                <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">City</label>
                                <input type="text" name="city" id="city" class="form-control"
                                       value="{{ old('city') }}">
                                @error('city')
                                <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Postal Code</label>
                            <input type="text" name="postal_code" id="postal_code" class="form-control"
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

                        @auth
                            @if(Auth::user()->loyalty_points > 0)
                                <div class="mb-3">
                                    <label class="form-label">
                                        Use loyalty points (you have {{ Auth::user()->loyalty_points }} pts)
                                    </label>
                                    <input type="number"
                                           name="use_points"
                                           class="form-control"
                                           min="0"
                                           max="{{ Auth::user()->loyalty_points }}"
                                           value="{{ old('use_points', 0) }}">
                                    <small class="text-muted">
                                        Minimum 100 points per discount step (100 pts = Rp 10.000).
                                    </small>
                                    @error('use_points')
                                    <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>
                            @endif
                        @endauth

                        <button type="submit" class="btn btn-pink fw-bold">
                            Place Order
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- sameri orderrrr --}}
        <div class="col-md-5">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h5 class="card-title mb-3">Order Summary</h5>

                    <ul class="list-group list-group-flush mb-3">
                        @php $rawTotal = 0; @endphp
                        @foreach($cart->items as $item)
                            @php
                                $line = $item->quantity * $item->price;
                                $rawTotal += $line;
                            @endphp
                            <li class="list-group-item d-flex justify-content-between">
                                <div>
                                    <strong>{{ $item->name }}</strong><br>
                                    <small class="text-muted">
                                        x {{ $item->quantity }}
                                    </small>
                                </div>
                                <div>
                                    Rp {{ number_format($line, 0, ',', '.') }}
                                </div>
                            </li>
                        @endforeach
                    </ul>

                    <div class="d-flex justify-content-between">
                        <strong>Total (before points)</strong>
                        <strong>Rp {{ number_format($rawTotal, 0, ',', '.') }}</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const select = document.getElementById('saved-address');
            if (!select) return;

            select.addEventListener('change', function () {
                const option = this.options[this.selectedIndex];
                if (!option.value) {
                    return;
                }

                document.getElementById('full_name').value   = option.dataset.full_name || '';
                document.getElementById('phone').value       = option.dataset.phone || '';
                document.getElementById('address_line').value= option.dataset.address_line || '';
                document.getElementById('city').value        = option.dataset.city || '';
                document.getElementById('province').value    = option.dataset.province || '';
                document.getElementById('postal_code').value = option.dataset.postal_code || '';
            });
        });
    </script>

</x-layout>
