<x-layout>

    <h3 class="mb-4">Buy Now</h3>

    <div class="row">
        <div class="col-md-7 mb-4">
            <div class="card shadow-sm border-0 mb-3">
                <div class="card-body">
                    <h5 class="card-title mb-3">Shipping & Payment</h5>

                    {{-- dropdown alamat --}}
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

                    <form method="POST" action="{{ route('products.buyNow.process', $product->id) }}">
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

                        <div class="mb-3">
                            <label class="form-label">Quantity</label>
                            <input type="number" name="quantity" id="quantity" class="form-control"
                                   min="1" value="{{ old('quantity', 1) }}">
                            @error('quantity')
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
                                        100 points = Rp 10.000 discount.
                                    </small>
                                    @error('use_points')
                                    <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>
                            @endif
                        @endauth

                        <button type="submit" class="btn btn-pink fw-bold">
                            Place Order Now
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- ringkasn 1 produk  --}}
        <div class="col-md-5">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h5 class="card-title mb-3">Order Summary</h5>

                    @php
                        $hasDiscount = $product->discount_percent > 0;
                    @endphp

                    <ul class="list-group list-group-flush mb-3">
                        <li class="list-group-item d-flex justify-content-between">
                            <div>
                                <strong>{{ $product->name }}</strong><br>
                                <small class="text-muted">
                                    {{ $product->category->name ?? '-' }}
                                </small>
                            </div>
                            <div class="text-end">
                                @if($hasDiscount)
                                    <div class="text-muted text-decoration-line-through">
                                        Rp {{ number_format($product->price, 0, ',', '.') }}
                                    </div>
                                    <div>
                                        Rp {{ number_format($basePrice, 0, ',', '.') }}
                                        <span class="badge bg-danger ms-1">-{{ $product->discount_percent }}%</span>
                                    </div>
                                @else
                                    Rp {{ number_format($basePrice, 0, ',', '.') }}
                                @endif
                            </div>
                        </li>
                    </ul>

                    <div class="d-flex justify-content-between">
                        <strong>Total (<span id="summary-qty">x1</span>)</strong>
                        <strong id="summary-total">
                            Rp {{ number_format($basePrice, 0, ',', '.') }}
                        </strong>
                    </div>

                    <small class="text-muted d-block mt-2">
                        Total will update based on chosen quantity.
                    </small>
                </div>
            </div>
        </div>
    </div>

    {{-- skrip tuk autofill n update total --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const price    = {{ $basePrice }}; // harga setelah diskon
            const qtyInput = document.getElementById('quantity');
            const qtyText  = document.getElementById('summary-qty');
            const totalText= document.getElementById('summary-total');

            function formatRupiah(num) {
                return 'Rp ' + num.toLocaleString('id-ID');
            }

            function updateTotal() {
                let q = parseInt(qtyInput.value || '1', 10);
                if (q < 1) q = 1;
                qtyInput.value      = q;
                qtyText.textContent = 'x' + q;
                totalText.textContent = formatRupiah(price * q);
            }

            if (qtyInput) {
                qtyInput.addEventListener('input', updateTotal);
                updateTotal();
            }

            const select = document.getElementById('saved-address');
            if (select) {
                select.addEventListener('change', function () {
                    const option = this.options[this.selectedIndex];
                    if (!option.value) return;

                    document.getElementById('full_name').value    = option.dataset.full_name || '';
                    document.getElementById('phone').value        = option.dataset.phone || '';
                    document.getElementById('address_line').value = option.dataset.address_line || '';
                    document.getElementById('city').value         = option.dataset.city || '';
                    document.getElementById('province').value     = option.dataset.province || '';
                    document.getElementById('postal_code').value  = option.dataset.postal_code || '';
                });
            }
        });
    </script>

</x-layout>
