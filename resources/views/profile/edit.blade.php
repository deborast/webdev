<x-layout>

    <div class="row justify-content-center mt-4">
        <div class="col-lg-8">

            <h3 class="mb-4">My Profile</h3>

            @if(session('success'))
                <div class="alert-maroon d-flex align-items-center mb-3">
                    <span class="alert-icon">✅</span>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <div class="card shadow-sm border-0 rounded-4 mb-4">
                <div class="card-body">
                    <p class="text-muted mb-2">
                        Loyalty points: <strong>{{ $user->loyalty_points }}</strong>
                    </p>

                    <h5 class="mb-3">Profile Information</h5>

                    <form method="POST" action="{{ route('profile.update') }}">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" name="name" class="form-control"
                                   value="{{ old('name', $user->name) }}">
                            @error('name')
                            <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control"
                                   value="{{ old('email', $user->email) }}">
                            @error('email')
                            <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <button class="btn btn-pink btn-elevated">
                            Save Changes
                        </button>
                    </form>
                </div>
            </div>

            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body">
                    <h5 class="mb-3">Change Password</h5>

                    <form method="POST" action="{{ route('profile.password') }}">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Current Password</label>
                            <input type="password" name="current_password" class="form-control">
                            @error('current_password')
                            <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">New Password</label>
                            <input type="password" name="password" class="form-control">
                            @error('password')
                            <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Confirm New Password</label>
                            <input type="password" name="password_confirmation" class="form-control">
                        </div>

                        <button class="btn btn-pink btn-elevated">
                            Update Password
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>

</x-layout>
