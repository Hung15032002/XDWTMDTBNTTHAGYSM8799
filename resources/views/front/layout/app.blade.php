<!DOCTYPE html>
<html class="no-js" lang="en_AU">
<head>
    <meta charset="UTF-8">
    <title>NỘI THẤT ĐÀ NẴNG</title>
    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, maximum-scale=1, user-scalable=no" />
    <meta name="HandheldFriendly" content="True" />
    <meta name="pinterest" content="nopin" />

    <!-- Social Metadata -->
    <meta property="og:locale" content="en_AU" />
    <meta property="og:type" content="website" />
    <meta property="og:site_name" content="" />
    <meta property="og:title" content="" />
    <meta property="og:description" content="" />
    <meta property="og:url" content="" />
    <meta property="og:image" content="" />
    <meta property="og:image:type" content="image/jpeg" />
    <meta property="og:image:width" content="" />
    <meta property="og:image:height" content="" />
    <meta property="og:image:alt" content="" />
    <meta name="twitter:title" content="" />
    <meta name="twitter:site" content="" />
    <meta name="twitter:description" content="" />
    <meta name="twitter:image" content="" />
    <meta name="twitter:image:alt" content="" />
    <meta name="twitter:card" content="summary_large_image" />

    <!-- Fonts and Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;500&family=Raleway:ital,wght@0,400;0,600;0,800;1,200&family=Roboto+Condensed:wght@400;700&family=Roboto:wght@300;400;700;900&display=swap" rel="stylesheet">

    <!-- CSS Assets -->
    <link rel="stylesheet" href="{{ asset('user_ass/css/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('user_ass/css/slick-theme.css') }}">
    <link rel="stylesheet" href="{{ asset('user_ass/css/video-js.css') }}">
    <link rel="stylesheet" href="{{ asset('user_ass/css/style.css') }}">

    <style>
        body {
            font-family: 'Roboto', sans-serif;
        }
    </style>

    <link rel="shortcut icon" type="image/x-icon" href="#" />
</head>
<body data-instant-intensity="mousedown">

<div class="bg-light top-header">        
    <div class="container">
        <div class="row align-items-center py-3 d-none d-lg-flex justify-content-between">
            <div class="col-lg-4 logo">
                <a href="{{ route('front.home')}}" class="text-decoration-none">
                    <span class="h1 text-uppercase text-primary bg-dark px-2">Nội Thất</span>
                    <span class="h1 text-uppercase text-dark bg-primary px-2 ml-n1">Đà Nẵng</span>
                </a>
            </div>
            <div class="col-lg-6 col-6 text-left d-flex justify-content-end align-items-center">
                <a href="{{ route('admin.login') }}" class="nav-link text-dark">Admin Account</a>
                <form action="">                    
                    <div class="input-group">
                        <input type="text" placeholder="Search For Products" class="form-control">
                        <span class="input-group-text">
                            <i class="fa fa-search"></i>
                        </span>
                    </div>
                </form>
                <!-- Add Cart Button -->
                <a href="{{ route('cart.show') }}" class="btn btn-primary ml-3">
                    <i class="fa fa-shopping-cart"></i> Giỏ hàng
                    @if(session('cart') && count(session('cart')) > 0)
                        <span class="badge badge-light">{{ count(session('cart')) }}</span>
                    @endif
                </a>
            </div>        
        </div>
    </div>
</div>

<header class="bg-dark">
    <div class="container">
        <nav class="navbar navbar-expand-xl" id="navbar">
            <a href="{{ route('front.home')}}" class="text-decoration-none mobile-logo">
                <span class="h2 text-uppercase text-primary bg-dark">Nội Thất</span>
                <span class="h2 text-uppercase text-white px-2">Đà Nẵng</span>
            </a>
            <button class="navbar-toggler menu-btn" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
                <i class="fas fa-bars"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    @foreach($categories as $category)
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdown{{ $category->id }}" role="button" data-bs-toggle="dropdown">
                                {{ $category->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-dark">
                                @foreach($subcategories as $subcategory)
                                    @if($subcategory->category_id == $category->id)
                                        <li>
                                            <a class="dropdown-item subcategory-link" href="#" data-id="{{ $subcategory->id }}">
                                                {{ $subcategory->name }}
                                            </a>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </li>
                    @endforeach
                </ul>
            </div>
        </nav>
    </div>
</header>

<main>
    @yield('content')
</main>

<footer class="bg-dark mt-5">
    <div class="container pb-5 pt-3">
        <div class="row">
            <div class="col-md-4">
                <div class="footer-card">
                    <h3>Get In Touch</h3>
                    <p>123 Street, New York, USA<br>
                    exampl@example.com<br>
                    000 000 0000</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="footer-card">
                    <h3>Important Links</h3>
                    <ul>
                        <li><a href="#">About</a></li>
                        <li><a href="#">Contact Us</a></li>
                        <li><a href="#">Privacy</a></li>
                        <li><a href="#">Terms & Conditions</a></li>
                        <li><a href="#">Refund Policy</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-md-4">
                <div class="footer-card">
                    <h3>My Account</h3>
                    <ul>
                        <li><a href="#">Login</a></li>
                        <li><a href="#">Register</a></li>
                        <li><a href="#">My Orders</a></li>
                    </ul>
                </div>
            </div>            
        </div>
    </div>
    <div class="copyright-area">
        <div class="container">
            <div class="row">
                <div class="col-12 mt-3">
                    <div class="copy-right text-center">
                        <p>© Copyright 2022 Amazing Shop. All Rights Reserved</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>

<!-- JS Scripts -->
<script src="{{ asset('user_ass/js/jquery-3.6.0.min.js') }}"></script>
<script src="{{ asset('user_ass/js/bootstrap.bundle.5.1.3.min.js') }}"></script>
<script src="{{ asset('user_ass/js/instantpages.5.1.0.min.js') }}"></script>
<script src="{{ asset('user_ass/js/lazyload.17.6.0.min.js') }}"></script>
<script src="{{ asset('user_ass/js/slick.min.js') }}"></script>
<script src="{{ asset('user_ass/js/custom.js') }}"></script>

<script>
    window.onscroll = function() {
        var navbar = document.getElementById("navbar");
        if (window.pageYOffset >= navbar.offsetTop) {
            navbar.classList.add("sticky");
        } else {
            navbar.classList.remove("sticky");
        }
    };
</script>

<script>
    $(document).ready(function() {
        $('.subcategory-link').click(function(e) {
            e.preventDefault();
            var subcategoryId = $(this).data('id');
            $.ajax({
                url: '/subcategory-products/' + subcategoryId,
                type: 'GET',
                success: function(response) {
                    $('.section-4 .row.pb-3').html('');
                    response.products.forEach(function(product) {
                        var productHtml = `
                            <div class="col-md-3">
                                <div class="card product-card">
                                    <div class="product-image position-relative">
                                        <a href="#" class="product-img">
                                            <img class="card-img-top" src="/uploads/product/${product.image}" alt="${product.name}">
                                        </a>
                                        <a class="whishlist" href="#"><i class="far fa-heart"></i></a>
                                        <div class="product-action">
                                            <a class="btn btn-dark" href="#"><i class="fa fa-shopping-cart"></i> Add To Cart</a>
                                        </div>
                                    </div>
                                    <div class="card-body text-center mt-3">
                                        <a class="h6 link" href="#">${product.name}</a>
                                        <div class="price mt-2">
                                            <span class="h5"><strong>${product.price} VND</strong></span>
                                            ${product.old_price ? `<span class="h6 text-underline"><del>${product.old_price} VND</del></span>` : ''}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `;
                        $('.section-4 .row.pb-3').append(productHtml);
                    });
                },
                error: function() {
                    alert('Không thể tải sản phẩm.');
                }
            });
        });
    });
</script>

</body>
</html>
