<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LaptopTech - Cửa hàng Laptop & Phụ kiện cao cấp</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Fira+Code:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <style>
        .font-fira {
            font-family: 'Fira Code', monospace !important;
        }

    :root {
    --primary-color: white;
    --header-bg: #1a1d20;
    }

    body {
    display: flex;
    flex-direction: column;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .container {
    flex: 1 0 auto;
    }

    .navbar-brand {
    font-weight: 800;
    letter-spacing: 1px;
    color: var(--primary-color) !important;
    }

    .nav-link {
    font-weight: 500;
    transition: 0.3s;
    }

    .nav-link:hover {
    color: var(--primary-color) !important;
    }

    .search-box {
    border-radius: 20px 0 0 20px;
    border: none;
    }

    .search-btn {
    border-radius: 0 20px 20px 0;
    padding-left: 20px;
    padding-right: 20px;
    }

    footer {
    flex-shrink: 0;
    border-top: 4px solid var(--primary-color);
    }

    .cart-badge {
    font-size: 0.7rem;
    vertical-align: top;
    }
    </style>
</head>

<body class="d-flex flex-column min-vh-100">

    <nav class="navbar navbar-expand-lg navbar-dark sticky-top" style="background-color: var(--header-bg); box-shadow: 0 2px 10px rgba(0,0,0,0.3);">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="/">
                <i class="bi bi-laptop me-2"></i>LAPTOP<span>TECH</span>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarMain">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link" href="/">Home</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                            Categories
                        </a>
                        <ul class="dropdown-menu shadow">
                            @if(isset($categories) && $categories->count() > 0)
                            @foreach($categories as $category)
                            <li>
                                <a class="dropdown-item" href="{{ route('category.show', $category->id) }}">
                                    {{ $category->name }}
                                </a>
                            </li>
                            @endforeach
                            @else
                            <li><a class="dropdown-item" href="#">Updating...</a></li>
                            @endif
                        </ul>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="#">Promotions</a></li>
                </ul>

                <form class="d-flex mx-lg-4 my-2 my-lg-0 w-100" action="{{ route('products.search') }}" method="GET" style="max-width: 400px;">
                    <input class="form-control search-box" type="search" placeholder="Search laptops, mice, keyboards..." name="query">
                    <button class="btn btn-primary search-btn" type="submit">
                        <i class="bi bi-search"></i>
                    </button>
                </form>

                <div class="d-flex align-items-center">
                    <ul class="navbar-nav">
                        @guest
                        <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
                        @else
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-info" href="#" data-bs-toggle="dropdown">
                                <i class="bi bi-person-circle me-1"></i> {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow">
                                @if(in_array(Auth::user()->role, ['admin', 'manager']))
                                <li><a class="dropdown-item text-danger" href="{{ route('admin.dashboard') }}">Admin</a></li>
                                @endif
                                <li><a class="dropdown-item" href="{{ route('profile.show')}}">My Profile</a></li>
                                <li><a class="dropdown-item" href="{{ route('orders.index') }}">My Orders</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item">Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                        @endguest
                    </ul>

                    <a href="/cart" class="btn btn-outline-warning position-relative ms-3">
                        <i class="bi bi-cart3"></i>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger cart-badge">
                            {{ $cartCount ?? 0 }}
                        </span>
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <div class="container mt-4 mb-5">
        <main class="flex-grow-1">
            @yield('content')
        </main>
    </div>

    <footer class="bg-dark text-white pt-5 pb-3">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <h5 class="text-primary fw-bold">LAPTOPTECH</h5>
                    <p class="small text-secondary">Provide high-quality laptops and computer components at competitive prices in Vietnam.</p>
                    <div class="d-flex gap-3 fs-5 text-secondary">
                        <i class="bi bi-facebook"></i>
                        <i class="bi bi-youtube"></i>
                        <i class="bi bi-tiktok"></i>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <h5 class="fw-bold text-white">Policies</h5>
                    <ul class="list-unstyled small text-secondary">
                        <li><a href="#" class="text-secondary text-decoration-none">Warranty Policy</a></li>
                        <li><a href="#" class="text-secondary text-decoration-none">Shipping & Returns</a></li>
                        <li><a href="#" class="text-secondary text-decoration-none">0% Interest Installments</a></li>
                    </ul>
                </div>
                <div class="col-md-4 mb-4">
                    <h5 class="fw-bold text-white">Contact</h5>
                    <p class="small text-secondary mb-1"><i class="bi bi-geo-alt me-2"></i> Hanoi, Vietnam</p>
                    <p class="small text-secondary mb-1"><i class="bi bi-telephone me-2"></i> 0123 456 789</p>
                    <p class="small text-secondary"><i class="bi bi-envelope me-2"></i> support@laptoptech.com</p>
                </div>
            </div>
            <hr class="bg-secondary">
            <div class="text-center">
                <p class="mb-0 small">© 2026 <strong>LaptopTech</strong>. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    @stack('scripts')
</body>

</html>