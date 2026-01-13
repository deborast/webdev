<x-layout>

    <div class="rounded-4 mb-5" style="background-color:#faf5f6;">
        <div class="row align-items-center p-4 p-lg-5">
            <div class="col-lg-6 mb-3 mb-lg-0">
                <img src="{{ asset('images/upward.png') }}" class="img-fluid rounded-4 shadow-sm"
                     alt="White Dove Coffee space">
            </div>

            <div class="col-lg-6 text-center text-lg-start">
                <span class="badge rounded-pill mb-2"
                      style="background-color:#fce8eb; color:#5b0b18; border:1px solid #f3d4da;">
                    Since 25 February 2023 • Near the rice fields
                </span>

                <h1 class="mb-3 fw-bold" style="color:#5b0b18;">
                    Welcome to White Dove Coffee
                </h1>
                <p class="mb-4" style="font-size:1.05rem;">
                    Browse, search, filter, and order your favorite drinks easily.
                    Enjoy the best coffee with a relaxing rice-field view.
                </p>

                @guest
                    <div class="d-flex flex-column flex-sm-row gap-2 justify-content-center justify-content-lg-start">
                        <a href="{{ route('login') }}" class="btn btn-outline-dark px-4">
                            Login
                        </a>
                        <a href="{{ route('register') }}" class="btn btn-pink px-4">
                            Register
                        </a>
                    </div>
                @else
                    <a href="{{ route('products.index') }}" class="btn btn-pink px-4">
                        Start Ordering
                    </a>
                @endguest
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card h-100 shadow-sm border-0">
                <div class="card-body">
                    <h5 class="fw-bold mb-2" style="color:#5b0b18;">Today’s Promo</h5>
                    <p class="mb-3">
                        Enjoy special prices for selected drinks and combos.
                        Perfect for hanging out with friends.
                    </p>
                    <a href="{{ route('promo') }}" class="link-maroon text-decoration-none">
                        View promo →
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card h-100 shadow-sm border-0">
                <div class="card-body">
                    <h5 class="fw-bold mb-2" style="color:#5b0b18;">News & Updates</h5>
                    <p class="mb-3">
                        New menu, events, and seasonal drinks at White Dove Coffee.
                        Stay up to date with what’s brewing.
                    </p>
                    <a href="{{ route('news') }}" class="link-maroon text-decoration-none">
                        Read news →
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card h-100 shadow-sm border-0">
                <div class="card-body">
                    <h5 class="fw-bold mb-2" style="color:#5b0b18;">Location</h5>
                    <p class="mb-3">
                        Located near the rice fields, perfect for chilling with
                        a natural green view and fresh air.
                    </p>
                    <a href="{{ route('location') }}" class="link-maroon text-decoration-none">
                        See location →
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="text-center mt-4">
        <h5 class="mb-2" style="color:#5b0b18;">Ready to order?</h5>
        <a href="{{ route('products.index') }}" class="btn btn-dark">
            Browse Products
        </a>
    </div>

</x-layout>
