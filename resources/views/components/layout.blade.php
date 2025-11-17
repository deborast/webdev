<!DOCTYPE html>
<html>
<head>
    <title>AFL1 - Products</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #ffe5c3;
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
    </style>
</head>

<body>
    <nav class="navbar p-3 mb-4 text-white">
        <h4 class="m-0">AFL1 - Product Management</h4>
    </nav>

    <div class="container">
        {{ $slot }}
    </div>
</body>
</html>
