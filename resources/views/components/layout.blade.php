<!DOCTYPE html>
<html>
<head>
    <title>Coffee Shop - Products</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #ffffff;
        }

        .top-navbar {
            background: #ffffff;
            border-bottom: 1px solid #ddd;
            min-height: 72px;
        }
        .brand-text {
            font-weight: 700;
            letter-spacing: 1px;
            color: #5b0b18;
            font-size: 1.3rem;
        }
        .navbar-brand span.me-2 {
            font-size: 2rem !important;
        }
        .nav-icon-btn {
            border: none;
            background: transparent;
            padding: 0;
            color: #000;
        }
        .nav-icon-btn span {
            font-size: 0.8rem;
        }
        .nav-icon-elevated {
            transition: transform 0.12s ease, box-shadow 0.12s ease, background-color 0.12s ease;
        }
        .nav-icon-elevated:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 14px rgba(0,0,0,0.18);
            border-radius: 999px;
            background-color: rgba(91,11,24,0.06);
        }
        .nav-icon-elevated:active {
            transform: translateY(0);
            box-shadow: 0 3px 8px rgba(0,0,0,0.22);
        }

        .hero {
            background-image: url('https://images.pexels.com/photos/373888/pexels-photo-373888.jpeg');
            background-size: cover;
            background-position: center;
            border-radius: 1rem;
            color: #fff;
        }
        .hero-overlay {
            background: rgba(0,0,0,0.55);
            border-radius: 1rem;
        }

        .btn-pink {
            background-color: #5b0b18;
            color: #fff;
        }
        .btn-pink:hover {
            background-color: #3b060f;
            color: #fff;
        }
        .btn-elevated {
            transition: transform 0.12s ease, box-shadow 0.12s ease, background-color 0.12s ease, color 0.12s ease;
            box-shadow: 0 0 0 rgba(0,0,0,0);
        }
        .btn-elevated:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 14px rgba(0,0,0,0.15);
        }
        .btn-elevated:active {
            transform: translateY(0);
            box-shadow: 0 3px 8px rgba(0,0,0,0.2);
        }

        .category-pill {
            border-radius: 999px;
            padding: 0.25rem 0.9rem;
            font-size: 0.8rem;
            border: 1px solid #ddd;
            background-color: #fff;
            color: #333;
            transition: background-color 0.12s ease, color 0.12s ease, box-shadow 0.12s ease, transform 0.12s ease;
        }
        .category-pill:hover {
            box-shadow: 0 4px 10px rgba(0,0,0,0.08);
            transform: translateY(-1px);
            background-color: #f8f1f3;
        }
        .category-pill-active {
            background-color: #5b0b18;
            color: #fff;
            border-color: #5b0b18;
            box-shadow: 0 4px 10px rgba(0,0,0,0.16);
        }
        .category-pill-active:hover {
            background-color: #3b060f;
            border-color: #3b060f;
        }

        .btn-outline-danger.custom-update {
            border-color: #5b0b18;
            color: #5b0b18;
            background-color: #fff;
        }
        .btn-outline-danger.custom-update:hover {
            border-color: #5b0b18;
            color: #fff !important;
            background-color: #5b0b18;
        }

        .btn-login-outline {
            border: 1px solid #000;
            color: #000;
            background-color: #fff;
            padding: 0.25rem 1.25rem;
        }

        .btn-login-outline:hover {
            background-color: #000000;
            color: #ffffff;
        }


        .btn-register-outline {
            border: 1px solid #5b0b18;
            color: #5b0b18;
            background-color: #fff;
            padding: 0.25rem 1.25rem;
        }

        .btn-register-outline:hover {
            background-color: #5b0b18;
            color: #fff;
        }


        .pagination .page-link {
            color: #5b0b18;
        }
        .pagination .page-item.active .page-link {
            background-color: #5b0b18;
            border-color: #5b0b18;
            color: #fff;
        }
        .pagination .page-link:hover {
            color: #3b060f;
        }

        .order-link {
            color: #5b0b18;
            font-weight: 500;
            text-decoration: none;
        }
        .order-link:hover {
            color: #3b060f;
            text-decoration: underline;
        }
        .order-card {
            transition: transform 0.15s ease, box-shadow 0.15s ease;
        }
        .order-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.12);
        }

        .alert-maroon {
            background-color: #fdf5f6;
            border-color: #f3d4da;
            color: #5b0b18;
            border-radius: 0.75rem;
            box-shadow: 0 4px 12px rgba(0,0,0,0.06);
            font-weight: 500;
        }
        .alert-maroon .alert-icon {
            font-size: 1.1rem;
            margin-right: 0.4rem;
        }
        .link-maroon {
            color: #5b0b18;
            font-weight: 500;
            text-decoration: none;
        }

        .link-maroon:hover {
            color: #3b060f;
            text-decoration: underline;
        }

    </style>
</head>

<body>
    <nav class="navbar top-navbar navbar-expand-lg mb-3">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="{{ route('products.index') }}">
                <span class="me-2" style="font-size:1.6rem;">☕</span>
                <span class="brand-text">COFFEE SHOP</span>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="mainNavbar">
                <ul class="navbar-nav me-auto"></ul>

                <div class="d-flex align-items-center gap-3">
                    @auth
                    <button class="nav-icon-btn nav-icon-elevated d-flex flex-column align-items-center"
                            type="button"
                            onclick="window.location.href='{{ route('products.index') }}#search-section'">
                        <div>🔍</div>
                        <span>Search</span>
                    </button>
                    @endauth

                    @auth
                        <a href="{{ route('orders.index') }}"
                           class="nav-icon-btn nav-icon-elevated d-flex flex-column align-items-center text-decoration-none">
                            <div>📜</div>
                            <span>Orders</span>
                        </a>

                        <a href="{{ route('cart.index') }}"
                           class="nav-icon-btn nav-icon-elevated d-flex flex-column align-items-center position-relative text-decoration-none">
                            <div>🛒</div>
                            <span>Cart</span>
                            @if(($cartCount ?? 0) > 0)
                                <span class="badge bg-danger rounded-pill position-absolute top-0 start-100 translate-middle">
                                    {{ $cartCount }}
                                </span>
                            @endif
                        </a>
                    @endauth

                    @auth
                        <a href="{{ route('profile.edit') }}"
                        class="nav-icon-btn nav-icon-elevated d-flex flex-column align-items-center text-decoration-none">
                            <div>👤</div>
                            <span style="font-size:0.75rem;">
                                {{ Str::limit(auth()->user()->name, 8) }}
                            </span>
                        </a>

                        <form method="POST" action="{{ route('logout') }}" class="ms-2">
                            @csrf
                            <button class="btn btn-sm btn-outline-dark">Logout</button>
                        </form>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-sm btn-login-outline me-2">
                                Login
                            </a>
                            <a href="{{ route('register') }}" class="btn btn-sm btn-register-outline">
                                Register
                            </a>
                        @endauth
                </div>
            </div>
        </div>
    </nav>

    <div class="container mb-3">
        <div class="hero p-4 mb-4">
            <div class="hero-overlay p-4 d-flex flex-column flex-md-row justify-content-between align-items-center">
                <div>
                    <h2 class="fw-bold mb-2">Welcome to Coffee Shop</h2>
                    <p class="mb-0">Browse, search, filter, and order your favorite drinks easily.</p>
                </div>
                <div class="mt-3 mt-md-0 d-flex gap-2">
                    <a href="{{ route('products.index') }}" class="btn btn-outline-light">
                        All Products
                    </a>
                    <a href="{{ route('products.create') }}" class="btn btn-pink fw-bold">
                        + Add New Product
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="container mb-5">
        {{ $slot }}
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
