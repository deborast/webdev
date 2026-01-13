<x-layout>

    <h3 class="mb-4">My Shipping Addresses</h3>

    @if(session('success'))
        <div class="alert-maroon d-flex align-items-center mb-3">
            <span class="alert-icon">✅</span>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <div class="row">
        {{-- buat form nambah alamat --}}
        <div class="col-md-7 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h5 class="card-title mb-3">Add New Address</h5>

                    <form method="POST" action="{{ route('shipping.store') }}">
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
                            <label class="form-label">Country</label>
                            <input type="text" name="country" class="form-control"
                                   value="{{ old('country') }}">
                            @error('country')
                            <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <button class="btn btn-pink fw-bold">
                            Save Address
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- daptar alamat--}}
        <div class="col-md-5 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h5 class="card-title mb-3">Saved Addresses</h5>

                    @if($addresses->isEmpty())
                        <p class="text-muted mb-0">You have not added any address yet.</p>
                    @else
                        <div class="list-group">
                            @foreach($addresses as $addr)
                                <div class="list-group-item d-flex justify-content-between align-items-start">
                                    <div>
                                        <strong>{{ $addr->full_name }}</strong><br>
                                        <small class="text-muted">
                                            {{ $addr->address_line }}<br>
                                            {{ $addr->city }}, {{ $addr->province }} {{ $addr->postal_code }}<br>
                                            {{ $addr->country }} • Phone: {{ $addr->phone }}
                                        </small>
                                    </div>
                                    <form method="POST"
                                          action="{{ route('shipping.destroy', $addr->id) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger">
                                            Remove
                                        </button>
                                    </form>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

</x-layout>
