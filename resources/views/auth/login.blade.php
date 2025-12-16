<x-layout>

    <div class="row justify-content-center mt-4">
        <div class="col-md-6 col-lg-5">

            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h4 class="mb-3">Login</h4>

                    @if(session('error'))
                        <div class="alert-maroon d-flex align-items-center mb-3"
                             style="background-color:#fce8eb; border-color:#f3b6c2; color:#7b1024;">
                            <span class="alert-icon">⚠️</span>
                            <span>{{ session('error') }}</span>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login.post') }}">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control"
                                   value="{{ old('email') }}" required autofocus>
                            @error('email')
                            <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" required>
                            @error('password')
                            <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <button class="btn btn-pink w-100 fw-bold">
                            Login
                        </button>
                    </form>
                    <p class="mt-3 mb-0 text-muted small">
                        Don't have an account yet?
                        <a href="{{ route('register') }}" class="link-maroon">Register here</a>.
                    </p>
                </div>
            </div>

        </div>
    </div>

</x-layout>
