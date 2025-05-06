<!DOCTYPE html>
<html lang="en_AU">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>NỘI THẤT ĐÀ NẴNG</title>
    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, maximum-scale=1, user-scalable=no" />
    <meta name="HandheldFriendly" content="True" />
    <meta name="pinterest" content="nopin" />

    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;500&family=Raleway:ital,wght@0,400;0,600;0,800;1,200&family=Roboto+Condensed:wght@400;700&family=Roboto:wght@300;400;700;900&display=swap" rel="stylesheet">
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
<body>

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
                {{-- Facebook --}}
                <a href="{{ $page->facebook_link }}" target="_blank" class="text-dark mx-2">
                    <i class="fab fa-facebook-f fa-lg"></i> Facebook
                </a>
                
                <a href="{{ $page->zalo_link }}" target="_blank" class="text-dark mx-2">
                    <i class="fas fa-comment-alt fa-lg"></i> Zalo
                </a>
                
            
                {{-- Admin & Giỏ hàng --}}
                <a href="{{ route('admin.login') }}" class="nav-link text-dark ml-2">Admin Account</a>
                <a href="{{ route('cart.show') }}" class="btn btn-primary ml-3">
                    <i class="fa fa-shopping-cart"></i> Giỏ hàng
                    <span id="cart-count">
                        @if(session('cart') && count(session('cart')) > 0)
                            <span class="badge badge-light">{{ count(session('cart')) }}</span>
                        @else
                            <span class="badge badge-light">0</span>
                        @endif
                    </span>
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

<footer class="bg-dark text-white py-4">
    <div class="container text-center">
        <div class="footer-card mb-3">
            <h4 class="mb-3">Liên hệ</h4>
            <p class="mb-1">
                {{-- Địa chỉ --}}
                <i class="fas fa-map-marker-alt me-2"></i>{{ $page->address ?? 'Địa chỉ chưa được cập nhật' }}
            </p>

            {{-- Số điện thoại --}}
            @if(!empty($page->phone_numbers))
                @foreach(json_decode($page->phone_numbers, true) as $phone)
                    <p class="mb-1">
                        <i class="fas fa-phone-alt me-2"></i>{{ $phone }}
                    </p>
                @endforeach
            @else
                <p class="mb-1"><i class="fas fa-phone-alt me-2"></i> Số điện thoại chưa được cập nhật</p>
            @endif
        </div>

        <div class="copyright text-white-50 mt-4">
            <p class="mb-0">© {{ now()->year }} Amazing Shop. All Rights Reserved</p>
        </div>
    </div>
</footer>


<script src="{{ asset('user_ass/js/jquery-3.6.0.min.js') }}"></script>
<script src="{{ asset('user_ass/js/bootstrap.bundle.5.1.3.min.js') }}"></script>
<script src="{{ asset('user_ass/js/instantpages.5.1.0.min.js') }}"></script>
<script src="{{ asset('user_ass/js/lazyload.17.6.0.min.js') }}"></script>
<script src="{{ asset('user_ass/js/slick.min.js') }}"></script>
<script src="{{ asset('user_ass/js/custom.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>


<script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('.add-to-cart-form').on('submit', function(e) {
            e.preventDefault();

            let form = $(this);
            let url = form.attr('action');
            let quantity = form.find('input[name="quantity"]').val();

            $.ajax({
                url: url,
                type: 'POST',
                data: { quantity: quantity },
                success: function(response) {
                    if (response.success) {
                        toastr.success(response.success);
                        $('#cart-count').text(response.cartCount);
                    } else {
                        toastr.error(response.error || 'Thêm vào giỏ hàng thất bại!');
                    }
                },
                error: function() {
                    toastr.error('Có lỗi xảy ra khi thêm sản phẩm vào giỏ!');
                }
            });
        });
    });
</script>

@yield('scripts')
</body>
</html>
