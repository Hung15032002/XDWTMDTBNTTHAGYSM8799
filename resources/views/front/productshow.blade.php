@extends('front.layout.app')

@section('content')
<section class="section-5 pt-3 pb-3 mb-3 bg-white">
    <div class="container">
        <div class="light-font">
            <ol class="breadcrumb primary-color mb-0">
                <li class="breadcrumb-item"><a class="white-text" href="{{ route('front.home') }}">Home</a></li>
                <li class="breadcrumb-item"><a class="white-text" href="{{ route('front.shop') }}">Shop</a></li>
                <li class="breadcrumb-item">{{ $product->title }}</li>
            </ol>
        </div>
    </div>
</section>

<section class="section-7 pt-3 mb-3">
    <div class="container">
        <div class="row">
            <!-- Carousel ảnh sản phẩm -->
            <div class="col-md-5">
                <div id="product-carousel" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner bg-light">
                        @if (!empty($product->images) && is_array($product->images))
                            @foreach($product->images as $key => $image)
                                <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                                    <img class="card-img-top" src="{{ asset('uploads/product/thumb/'.$image) }}" alt="{{ $product->title }}">
                                </div>
                            @endforeach
                        @else
                            <p>No images available</p>
                        @endif
                    </div>
                    <a class="carousel-control-prev" href="#product-carousel" data-bs-slide="prev">
                        <i class="fa fa-2x fa-angle-left text-dark"></i>
                    </a>
                    <a class="carousel-control-next" href="#product-carousel" data-bs-slide="next">
                        <i class="fa fa-2x fa-angle-right text-dark"></i>
                    </a>
                </div>
            </div>

            <!-- Thông tin sản phẩm -->
            <div class="col-md-7">
                <div class="bg-light p-4 rounded shadow-sm">
                    <h2 class="mb-3" style="font-size: 24px; font-weight: 600; color: #333;">
                        Thông tin sản phẩm
                    </h2>
                    <ul class="list-unstyled" style="font-size: 16px; color: #444;">
                        <li class="mb-3"><strong>Tên sản phẩm:</strong> {{ $product->title }}</li>
                        <li class="mb-3">
                            <strong>Giá:</strong> 
                            @if($product->price_compare)
                                <del class="text-muted">{{ number_format($product->price_compare, 0) }} VNĐ</del>
                            @endif
                            <span class="text-danger fw-bold ms-2">{{ number_format($product->price, 0) }} VNĐ</span>
                        </li>
                        <li class="mb-3"><strong>Mã sản phẩm:</strong> {{ $product->code ?? 'N/A' }}</li>
                        <li class="mb-3"><strong>Xuất xứ:</strong> {{ $product->origin ?? 'Đang cập nhật' }}</li>
                        <li class="mb-3"><strong>Chất liệu:</strong> {{ $product->material ?? 'Đang cập nhật' }}</li>
                        <li class="mb-3"><strong>Kích thước:</strong> {{ $product->dimensions ?? 'Đang cập nhật' }}</li>
                        <li class="mb-3"><strong>Màu sắc:</strong> {{ $product->color ?? 'Đang cập nhật' }}</li>
                        <li class="mb-3"><strong>Bảo hành:</strong> {{ $product->warranty ?? '1 Năm' }}</li>
                        <li class="mb-3"><strong>Chú thích:</strong> {{ $product->description ?? 'N/A' }}</li>
                        <li class="mb-3"><strong>Thông tin vận chuyển:</strong> Giao hàng toàn quốc trong 2 - 5 ngày làm việc.</li>
                        <li class="mb-3">
                            <strong>Tình trạng:</strong> 
                            @if($product->status == 1)
                                <span class="text-success">Còn hàng</span>
                            @else
                                <span class="text-danger">Hết hàng</span>
                            @endif
                        </li>
                        <li class="mb-3">
                            <strong>Liên hệ:</strong> 
                            <span class="text-success">0123456789</span>
                        </li>
                          <form method="POST" action="{{ route('cart.addToCart', ['id' => $product->id]) }}" class="mt-3 add-to-cart-form">
                            @csrf
                            <input type="hidden" name="quantity" value="1">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fa fa-shopping-cart"></i> Thêm vào giỏ hàng
                            </button>
                        </form>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Sản phẩm liên quan -->
<section class="pt-5 section-9">
    <div class="container">
        @if(isset($recommendedProducts) && $recommendedProducts->count())
            <div class="mt-5">
                <h4 class="mb-4 fw-bold">Có thể bạn sẽ thích</h4>
                <div class="row g-4">
                    @foreach($recommendedProducts as $rec)
                        <div class="col-6 col-md-3">
                            <div class="card product-card h-100 shadow-sm border-0">
                                <div class="position-relative overflow-hidden">
                                    <a href="{{ route('front.product.show', $rec->id) }}" class="d-block">
                                        @php
                                            $images = explode(',', $rec->image);
                                            $thumb = isset($images[0]) ? $images[0] : 'default.jpg';
                                        @endphp
                                        <img class="card-img-top img-fluid rounded-3" 
                                             src="{{ asset('uploads/product/thumb/' . $thumb) }}" 
                                             alt="{{ $rec->name }}"
                                             onerror="this.src='{{ asset('uploads/product/thumb/default.jpg') }}';"
                                             style="transition: transform 0.3s ease;">
                                    </a>
                                    <a href="#" class="whishlist position-absolute top-0 end-0 m-2 text-danger fs-5" title="Thêm vào yêu thích">
                                        <i class="far fa-heart"></i>
                                    </a>
                                    <div class="product-action position-absolute bottom-0 start-50 translate-middle-x mb-3 d-none">
                                        <form method="POST" action="{{ route('cart.addToCart', ['id' => $rec->id]) }}" class="add-to-cart-form">
                                            @csrf
                                            <input type="hidden" name="quantity" value="1">
                                            <button type="submit" class="btn btn-dark btn-sm px-3 add-to-cart-btn">
                                                <i class="fa fa-shopping-cart me-1"></i> Add To Cart
                                            </button>
                                        </form>
                                    </div>
                                </div>
                                <div class="card-body text-center py-3">
                                    <a class="h6 link-dark text-decoration-none d-block mb-2" href="{{ route('front.product.show', $rec->id) }}" title="{{ $rec->name }}">
                                        {{ \Illuminate\Support\Str::limit($rec->name, 50) }}
                                    </a>
                                    <div class="price">
                                        <span class="h5 fw-bold text-primary">{{ number_format($rec->price, 0, ',', '.') }} VND</span>
                                        @if($rec->old_price)
                                            <span class="text-muted ms-2" style="text-decoration: line-through; font-size: 0.9rem;">
                                                {{ number_format($rec->old_price, 0, ',', '.') }} VND
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @else
            <p class="text-center text-muted fs-5">Không có sản phẩm gợi ý.</p>
        @endif
    </div>
</section>

<style>
    /* Hover effect cho ảnh */
    .product-card .card-img-top:hover {
        transform: scale(1.05);
    }

    /* Hiện nút Add to Cart khi hover card */
    .product-card:hover .product-action {
        display: block !important;
    }

    /* Tùy chỉnh icon yêu thích */
    .whishlist:hover {
        color: #dc3545; /* đỏ bootstrap */
        cursor: pointer;
    }
</style>





@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css"/>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
document.querySelectorAll('.add-to-cart-form').forEach(form => {
    form.addEventListener('submit', function (e) {
        e.preventDefault();

        const formButton = form.querySelector('.add-to-cart-btn');
        if (formButton.disabled) return;

        formButton.disabled = true;

        const url = form.getAttribute('action');
        const quantity = form.querySelector('input[name="quantity"]').value;

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
                formButton.disabled = false;
            }
        });
    });
});
</script>
@endsection