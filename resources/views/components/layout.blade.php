<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>White Dove Coffee</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Bootstrap CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        :root { --main-maroon: #5b0b18; }

        body { background-color: #ffffff; }

        .navbar-brand {
            font-weight: 700;
            color: var(--main-maroon) !important;
        }
        .navbar-brand img { height: 40px; }

        .nav-link { color: #555555; }
        .navbar-nav .nav-link:hover { color: var(--main-maroon); }
        .nav-link.active { font-weight: 600; }

        .btn-pink {
            background-color: #e66b8d;
            border-color: #e66b8d;
            color: #fff;
        }
        .btn-pink:hover {
            background-color: #d7577c;
            border-color: #d7577c;
        }

        .link-maroon { color: var(--main-maroon); }
        .link-maroon:hover { color: #3b0610; }

        .alert-maroon {
            background-color:#fce8eb;
            border-color:#f3b6c2;
            color:#7b1024;
            border-radius: .75rem;
            padding: .75rem 1rem;
        }

        .alert-icon {
            display:inline-block;
            margin-right:.5rem;
        }

        .category-pill {
            display:inline-block;
            padding:.25rem .75rem;
            border-radius:999px;
            border:1px solid #f3d4da;
            background-color:#fff;
            color:var(--main-maroon);
            font-size:.85rem;
        }
        .category-pill-active {
            background-color:var(--main-maroon);
            color:#fff;
            border-color:var(--main-maroon);
        }

        .btn-elevated { box-shadow:0 .25rem .5rem rgba(0,0,0,.08); }

        .page-item.active .page-link {
            background-color: var(--main-maroon);
            border-color: var(--main-maroon);
            color: #fff;
        }
        .page-link { color: var(--main-maroon); }
        .page-link:hover { color: #3b0610; }

        .hover-shadow:hover {
            transform: translateY(-2px);
            box-shadow:0 .5rem 1rem rgba(0,0,0,.12);
            transition: all .15s ease-in-out;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">
            <img src="{{ asset('images/logo1.png') }}" alt="White Dove Coffee Logo">
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#mainNavbar" aria-controls="mainNavbar"
                aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-end" id="mainNavbar">
            <ul class="navbar-nav mb-2 mb-lg-0">

                {{-- hum --}}
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}"
                       href="{{ route('home') }}">
                        Home
                    </a>
                </li>

                @php
                    $navCategories = \App\Models\Category::orderBy('name')->get();
                @endphp

                {{-- produk dropdown n kategoreh --}}
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle {{ request()->routeIs('products.*') ? 'active' : '' }}"
                       href="{{ route('products.categories') }}"
                       role="button"
                       data-bs-toggle="dropdown"
                       aria-expanded="false">
                        Products
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item"
                               href="{{ route('products.index') }}">
                                All
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        @foreach($navCategories as $cat)
                            <li>
                                <a class="dropdown-item"
                                   href="{{ route('products.index', ['category_id' => $cat->id]) }}">
                                    {{ $cat->name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </li>

                {{-- bwt statis --}}
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('promo') ? 'active' : '' }}"
                       href="{{ route('promo') }}">
                        Promo
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('news') ? 'active' : '' }}"
                       href="{{ route('news') }}">
                        News
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('location') ? 'active' : '' }}"
                       href="{{ route('location') }}">
                        Location
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}"
                       href="{{ route('about') }}">
                        About Us
                    </a>
                </li>

                {{-- user n atmin --}}
                @auth
                    @php $user = Auth::user(); @endphp

                    @if(!$user->isAdmin())
                        {{-- akun biasa --}}
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle"
                               href="#"
                               role="button"
                               data-bs-toggle="dropdown"
                               aria-expanded="false">
                                {{ $user->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a class="dropdown-item d-flex align-items-center gap-2"
                                       href="{{ route('wishlist.index') }}">
                                        <span>❤️</span><span>Wishlist</span>
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item d-flex align-items-center gap-2"
                                       href="{{ route('cart.index') }}">
                                        <span>🛒</span><span>Cart</span>
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item d-flex align-items-center gap-2"
                                       href="{{ route('orders.index') }}">
                                        <span>📦</span><span>Orders</span>
                                    </a>
                                </li>

                                <li><hr class="dropdown-divider"></li>

                                <li>
                                    <a class="dropdown-item d-flex align-items-center gap-2"
                                       href="{{ route('profile.edit') }}">
                                        <span>👤</span><span>Profile</span>
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item d-flex align-items-center gap-2"
                                       href="{{ route('shipping.index') }}">
                                        <span>📍</span><span>Shipping Addresses</span>
                                    </a>
                                </li>

                                <li><hr class="dropdown-divider"></li>

                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button class="dropdown-item d-flex align-items-center gap-2">
                                            <span>🚪</span><span>Logout</span>
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        {{-- aatminzzzzzzz --}}
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle"
                               href="#"
                               role="button"
                               data-bs-toggle="dropdown"
                               aria-expanded="false">
                                {{ $user->name }} (Admin)
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a class="dropdown-item d-flex align-items-center gap-2"
                                       href="{{ route('products.index') }}">
                                        <span>📦</span><span>Manage Products</span>
                                    </a>
                                </li>
                                {{-- kl mau nambahi menu lain atmin --}}
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button class="dropdown-item d-flex align-items-center gap-2">
                                            <span>🚪</span><span>Logout</span>
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endif
                @endauth

                @guest
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('login') ? 'active' : '' }}"
                           href="{{ route('login') }}">
                            Login
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('register') ? 'active' : '' }}"
                           href="{{ route('register') }}">
                            Register
                        </a>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>

<main class="py-4">
    <div class="container">
        {{ $slot }}
    </div>
</main>

<footer class="mt-5 py-4" style="background-color:#f7f3f4;">
    <div class="container text-center">
        <div class="mb-2">
            <a href="https://www.instagram.com/whitedove.coffee/" target="_blank">
                <img src="{{ asset('images/instagram.png') }}" alt="Instagram" style="height:24px; margin-right:8px;">
            </a>
            <a href="https://wa.me/6282277638263" target="_blank">
                <img src="{{ asset('images/whatsapp.png') }}" alt="WhatsApp" style="height:24px; margin-right:8px;">
            </a>
            <a href="mailto:whitedove.kds@gmail.com" target="_blank">
                <img src="{{ asset('images/gmail.png') }}" alt="Email" style="height:24px;">
            </a>
        </div>
        <div class="small text-muted">
            © 2026 White Dove Coffee. All rights reserved.
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
