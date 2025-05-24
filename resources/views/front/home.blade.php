@extends('front.layout.app')

@section('content')

<!-- Section 1: Carousel -->
<section class="section-1">
    <div id="carouselExampleIndicators" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="5000">
        <div class="carousel-inner">

            <!-- Slide 1 -->
            <div class="carousel-item active">
                <picture>
                    <source media="(max-width: 799px)" srcset="{{ asset('user_ass/images/anhslide/slide1.jpg') }}" />
                    <source media="(min-width: 800px)" srcset="{{ asset('user_ass/images/anhslide/slide1.jpg') }}" />
                    <img src="{{ asset('user_ass/images/anhslide/slide1.jpg') }}" class="d-block w-100" alt="Slide 1" />
                </picture>
                <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                    <div class="p-3">
                        <h1 class="display-4 text-white mb-3">NỘI THẤT ĐÀ NẴNG</h1>
                        <p class="mx-md-5 px-5">Nơi trang trí theo phong cách của bạn</p>
                        <a class="btn btn-outline-light py-2 px-4 mt-3" href="{{ route('front.shop') }}">Shop Now</a>
                    </div>
                </div>
            </div>

            <!-- Slide 2 -->
            <div class="carousel-item">
                <picture>
                    <source media="(max-width: 799px)" srcset="{{ asset('user_ass/images/anhslide/slide2.jpg') }}" />
                    <source media="(min-width: 800px)" srcset="{{ asset('user_ass/images/anhslide/slide2.jpg') }}" />
                    <img src="{{ asset('user_ass/images/anhslide/slide2.jpg') }}" class="d-block w-100" alt="Slide 2" />
                </picture>
                <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                    <div class="p-3">
                        <h1 class="display-4 text-white mb-3">NỘI THẤT ĐÀ NẴNG</h1>
                        <p class="mx-md-5 px-5">Nơi trang trí theo phong cách của bạn</p>
                        <a class="btn btn-outline-light py-2 px-4 mt-3" href="{{ route('front.shop') }}">Shop Now</a>
                    </div>
                </div>
            </div>

            <!-- Slide 3 -->
            <div class="carousel-item">
                <picture>
                    <source media="(max-width: 799px)" srcset="{{ asset('user_ass/images/anhslide/slide3.jpg') }}" />
                    <source media="(min-width: 800px)" srcset="{{ asset('user_ass/images/anhslide/slide3.jpg') }}" />
                    <img src="{{ asset('user_ass/images/anhslide/slide3.jpg') }}" class="d-block w-100" alt="Slide 3" />
                </picture>
                <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                    <div class="p-3">
                        <h1 class="display-4 text-white mb-3">NỘI THẤT ĐÀ NẴNG</h1>
                        <p class="mx-md-5 px-5">Nơi trang trí theo phong cách của bạn</p>
                        <a class="btn btn-outline-light py-2 px-4 mt-3" href="{{ route('front.shop') }}">Shop Now</a>
                    </div>
                </div>
            </div>

        </div>
        <!-- Carousel controls -->
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</section>

<!-- Section 2: Lợi ích -->
<section class="section-2">
    <div class="container">
        <div class="row">
            @php
                $features = [
                    ['icon' => 'fa-check', 'text' => 'Chất Lượng Tốt'],
                    ['icon' => 'fa-shipping-fast', 'text' => 'Miễn Phí Vận Chuyển'],
                    ['icon' => 'fa-exchange-alt', 'text' => 'Hoàn Trả Trong 2 Tuần'],
                    ['icon' => 'fa-phone-volume', 'text' => 'Hỗ Trợ 24/7']
                ];
            @endphp
            @foreach($features as $feature)
                <div class="col-lg-3">
                    <div class="box shadow-lg d-flex align-items-center p-3">
                        <div class="fa icon {{ $feature['icon'] }} text-primary me-3"></div>
                        <h2 class="font-weight-semi-bold m-0">{{ $feature['text'] }}</h2>
                    </div>                    
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Section 3: Danh mục sản phẩm -->
<section class="section-3">
    <div class="container">
        <div class="section-title">
            <h2>DANH MỤC SẢN PHẨM</h2>
        </div>
        <div class="row pb-3">
            @foreach($categories as $category)
            <div class="col-lg-3">
                <div class="cat-card">
                    <div class="left">
                        <img src="{{ asset('uploads/category/thumb/' . $category->image) }}" alt="{{ $category->name }}" class="img-fluid">
                    </div>
                    <div class="right">
                        <div class="cat-data">
                            <h2>{{ $category->name }}</h2>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Section 4: Sản phẩm -->
<section class="section-4 pt-5">
    <div class="container">
        <div class="section-title">
            <h2>SẢN PHẨM</h2>
        </div>    
        <div class="row pb-3">
            @foreach($products as $product)
            <div class="col-md-3">
                <div class="card product-card">
                    <div class="product-image position-relative">
                        <a href="{{ route('front.product.show', $product->id) }}" class="product-img">
                            <img class="card-img-top" src="{{ asset('uploads/product/thumb/' . $product->image) }}" alt="{{ $product->name }}">
                        </a>
                        <a class="whishlist" href="#"><i class="far fa-heart"></i></a>
                       <div class="product-action">
                                            <form method="POST" action="{{ route('cart.addToCart', ['id' => $product->id]) }}" class="add-to-cart-form">
                                                @csrf
                                                <input type="hidden" name="quantity" value="1">
                                                <button type="submit" class="btn btn-dark mt-2 add-to-cart-btn">
                                                    <i class="fa fa-shopping-cart"></i> Add To Cart
                                                </button>
                                            </form>
                                        </div>
                    </div>
                    <div class="card-body text-center mt-3">
                        <a class="h6 link" href="{{ route('front.product.show', $product->id) }}">{{ $product->name }}</a>
                        <div class="price mt-2">
                            <span class="h5"><strong>{{ number_format($product->price, 0, ',', '.') }} VND</strong></span>
                            @if($product->old_price)
                            <span class="h6 text-muted ms-2"><del>{{ number_format($product->old_price, 0, ',', '.') }} VND</del></span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endforeach              
        </div>
    </div>
</section>

@endsection
@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css"/>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function() {
    // Hủy bỏ các event submit cũ (nếu có) rồi gán lại sự kiện submit cho các form add-to-cart
    $('.add-to-cart-form').off('submit').on('submit', function (e) {
        e.preventDefault();

        const form = this;
        const formButton = $(form).find('.add-to-cart-btn');

        // Nếu nút đã disabled thì không làm gì thêm
        if (formButton.prop('disabled')) return;

        formButton.prop('disabled', true);

        const url = $(form).attr('action');
        const quantity = $(form).find('input[name="quantity"]').val();

        $.ajax({
            url: url,
            method: 'POST',
            data: {
                quantity: quantity,
            },
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            success: function (data) {
                if (data.success) {
                    toastr.success(data.success);

                    // Cập nhật số lượng sản phẩm trong giỏ (nếu có phần tử #cart-count)
                    const cartCountElement = document.getElementById('cart-count');
                    if (cartCountElement) {
                        cartCountElement.textContent = data.cartCount;
                    }
                } else {
                    toastr.error(data.error || 'Thêm sản phẩm thất bại!');
                }
            },
            error: function (xhr) {
                const error = xhr.responseJSON?.error || 'Lỗi khi thêm vào giỏ hàng!';
                toastr.error(error);
            },
            complete: function() {
                // Mở lại nút submit
                formButton.prop('disabled', false);
            }
        });
    });
});
</script>
@endsection
