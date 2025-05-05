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

            <div class="col-md-7">
                <div class="bg-light right" >
                    <div class="bg-light p-4 rounded shadow-sm">
                        <h2 class="mb-3" style="font-size: 24px; font-weight: 600; color: #333;">
                            Thông tin sản phẩm
                        </h2>
                    
                        <ul class="list-unstyled" style="font-size: 16px; color: #444;">
                            <li class="mb-3"><strong>Tên sản phẩm:</strong> {{ $product->title }}</li>
                    
                            <li class="mb-3">
                                <strong>Giá:</strong> 
                                @if($product->price_compare)
                                    <del class="text-muted">{{ number_format($product->price_compare, 2) }} VNĐ</del>
                                @endif
                                <span class="text-danger fw-bold ms-2">{{ number_format($product->price, 2) }} VNĐ</span>
                            </li>
                            <li class="mb-3"><strong>Mã sản phẩm:</strong> {{ $product->code ?? 'N/A' }}</li>
                            <li class="mb-3"><strong>Xuất xứ:</strong> {{ $product->origin ?? 'Đang cập nhật' }}</li>
                            <li class="mb-3"><strong>Chất liệu:</strong> {{ $product->material ?? 'Đang cập nhật' }}</li>
                            <li class="mb-3"><strong>Kích thước:</strong> {{ $product->dimensions ?? 'Đang cập nhật' }}</li>
                            <li class="mb-3"><strong>Màu Sắc:</strong> {{ $product->color ?? 'Đang cập nhật' }}</li>
                            <li class="mb-3"><strong>Bảo Hành:</strong> {{ $product->warranty ?? '1 Năm' }}</li>
                            <li class="mb-3"><strong>Chú thích:</strong> {{ $product->description  ?? 'N/A' }}</li>
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
                                <strong>Liên Hệ:</strong> 
                                <span class="text-success">0123456789</span>
                            </li>
                        </ul>
                    </div>
                    
            </div>



          
        </div>
    </div>
</section>
<section class="pt-5 section-8">
    <section class="pt-5 section-8">
        <div class="container">
            <div class="section-title">
                <h2>Sản phẩm liên quan</h2>
            </div>
            <div class="row">
                @forelse($relatedProducts as $related)
                    <div class="col-md-3 mb-4">
                        <div class="card product-card">
                            <div class="product-image position-relative">
                                <a href="{{ route('front.product.show', $related->id) }}" class="product-img">
                                    @php
                                        // Giải mã chuỗi ảnh từ trường 'image'
                                        $images = explode(',', $related->image); 
                                        // Kiểm tra và lấy ảnh đầu tiên
                                        $thumb = isset($images[0]) ? $images[0] : 'default.jpg'; 
                                    @endphp
    
                                    <!-- Kiểm tra và hiển thị ảnh -->
                                    <img class="card-img-top" 
                                        src="{{ asset('uploads/product/thumb/' . $thumb) }}" 
                                        alt="{{ $related->name }}"
                                        onerror="this.src='{{ asset('uploads/product/thumb/default.jpg') }}';">
                                </a>
    
                                <a class="whishlist" href="#"><i class="far fa-heart"></i></a>
    
                                <div class="product-action">
                                    <a class="btn btn-dark" href="">
                                        <i class="fa fa-shopping-cart"></i> Thêm vào giỏ hàng
                                    </a>
                                </div>
                            </div>
    
                            <div class="card-body text-center mt-3">
                                <!-- Hiển thị tên sản phẩm và liên kết tới chi tiết sản phẩm -->
                                <a class="h6 text-underline" href="{{ route('front.product.show', $product->id) }}">{{ $product->name }}</a>
                                    {{ $related->title }} <!-- Hiển thị tên sản phẩm -->
                                </a>
                                <div class="price mt-2">
                                    <span class="h5"><strong>{{ number_format($related->price, 0) }} VNĐ</strong></span>
                                    @if($related->price_compare)
                                        <span class="h6 text-underline"><del>{{ number_format($related->price_compare, 0) }} VNĐ</del></span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-center">Không có sản phẩm liên quan.</p>
                @endforelse
            </div>
        </div>
    </section>
</section>

@endsection
