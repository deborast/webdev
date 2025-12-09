<!DOCTYPE html>
<html>
<head>
    <title>Coffee Shop - Products</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(180deg, #ffe5c3 0%, #fff7ea 100%);
        }
        .navbar {
            background: #f58217;
        }
        .btn-pink {
            background-color: #ff7b00;
            color: white;
        }
        .btn-pink:hover {
            background-color: #975600;
            color: white;
        }
        .hero {
            background-image: url('https://images.pexels.com/photos/302899/pexels-photo-302899.jpeg');
            background-size: cover;
            background-position: center;
            border-radius: 1rem;
            color: white;
        }
        .hero-overlay {
            background: rgba(0,0,0,0.5);
            border-radius: 1rem;
        }


    </style>
</head>

<body>
    <nav class="navbar p-3 mb-4 text-white">
        <div class="container d-flex justify-content-between align-items-center">

            <div class="d-flex align-items-center">
                <div class="rounded-circle d-flex justify-content-center align-items-center me-3"
                     style="width:46px; height:46px; background:#fffbf2; color:#b35400; font-size:1.8rem;">
                    ☕
                </div>
                <div class="d-flex flex-column">
                    <span class="fw-bold" style="font-size:1.3rem; letter-spacing:0.5px;">
                        Web Development UCO
                    </span>
                    <small class="text-light" style="font-size:0.85rem;">
                        Product Management Coffee Shop
                    </small>
                </div>
            </div>

            <a href="{{ route('products.index') }}"
               class="btn btn-sm d-flex align-items-center px-3 py-2"
               style="background-color:#fffbf2; color:#ff7b00; border-radius:999px; border:1px solid #ffd5a3;">
                <span class="me-2" style="font-size:1.1rem;">🏠</span>
                <span class="fw-semibold">HOME</span>
            </a>

        </div>
    </nav>

    <div class="container mb-4">
        <div class="hero p-4 mb-4">
            <div class="hero-overlay p-4 d-flex flex-column flex-md-row justify-content-between align-items-center">
                <div>
                    <h2 class="fw-bold mb-2">Welcome to Coffee Shop</h2>
                    <p class="mb-0">Browse, search, and filter your favorite drinks easily.</p>
                </div>
                <div class="mt-3 mt-md-0">
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
</body>
</html>
