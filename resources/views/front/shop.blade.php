@extends('front.layout.app')

@section('content')
<section class="section-1">
    <section class="section-5 pt-3 pb-3 mb-3 bg-white">
        <div class="container">
            <div class="light-font">
                <ol class="breadcrumb primary-color mb-0">
                    <li class="breadcrumb-item"><a class="white-text" href="{{ route('front.home') }}">Home</a></li>
                    <li class="breadcrumb-item active">Shop</li>
                </ol>
            </div>
        </div>
    </section>

    <section class="section-6 pt-5">
        <div class="container">
            <div class="row">
                <!-- Sidebar -->
                <div class="col-md-3 sidebar">
                    <form method="GET" action="{{ route('front.shop') }}">
                        <!-- Categories Section -->
                        <div class="sub-title">
                            <h2>Danh Mục Sản Phẩm</h2>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <div class="accordion accordion-flush" id="accordionExample">
                                    @if($categories->isNotEmpty())
                                        @foreach($categories as $category)
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="heading{{ $loop->index }}">
                                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $loop->index }}" aria-expanded="false" aria-controls="collapse{{ $loop->index }}">
                                                        {{ $category->name }}
                                                    </button>
                                                </h2>
                                                <div id="collapse{{ $loop->index }}" class="accordion-collapse collapse" aria-labelledby="heading{{ $loop->index }}" data-bs-parent="#accordionExample">
                                                    <div class="accordion-body">
                                                        @if($category->subcategories && $category->subcategories->isNotEmpty())
                                                            @foreach($category->subcategories as $subcategory)
                                                                <div class="form-check mb-2">
                                                                    <input class="form-check-input" type="checkbox" name="subcategory[]" value="{{ $subcategory->id }}" id="subcategory{{ $subcategory->id }}" {{ in_array($subcategory->id, request('subcategory', [])) ? 'checked' : '' }}>
                                                                    <label class="form-check-label" for="subcategory{{ $subcategory->id }}">
                                                                        {{ $subcategory->name }}
                                                                    </label>
                                                                </div>
                                                            @endforeach
                                                        @else
                                                            <p>Không có danh mục con.</p>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <p>Không có danh mục.</p>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Brands Section -->
                        <div class="sub-title mt-5">
                            <h2>Nhãn Hàng</h2>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                @foreach($brands as $brand)
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" name="brand[]" value="{{ $brand->id }}" id="brand{{ $brand->id }}" {{ in_array($brand->id, request('brand', [])) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="brand{{ $brand->id }}">
                                            {{ $brand->name }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Price Range Section -->
                        <div class="sub-title mt-5">
                            <h2>Lọc Giá</h2>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                @php
                                    $priceRanges = [
                                        '0-1000000' => '0 VND - 1 triệu VND',
                                        '1000000-5000000' => '1 triệu VND - 5 triệu VND',
                                        '5000000-20000000' => '5 triệu VND - 20 triệu VND',
                                        '20000000-50000000' => '20 triệu VND - 50 triệu VND',
                                        '50000000-100000000' => '50 triệu VND - 100 triệu VND',
                                        '100000000-500000000' => '100 triệu VND - 500 triệu VND',
                                        '500000000+' => '500 triệu VND+',
                                    ];
                                @endphp
                                @foreach($priceRanges as $key => $label)
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" name="price[]" value="{{ $key }}" id="price{{ $key }}" {{ in_array($key, request('price', [])) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="price{{ $key }}">
                                            {{ $label }}
                                        </label>
                                    </div>
                                @endforeach

                                <button type="submit" class="btn btn-primary mt-3">Áp dụng bộ lọc</button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Products Section -->
                <div class="col-md-9">
                    <!-- Sort Products -->
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <form method="GET" action="{{ url()->current() }}" class="form-inline">
                                <label for="sort" class="mr-2">Sắp xếp:</label>
                                <select name="sort" id="sort" class="form-control" onchange="this.form.submit()">
                                    <option value="" {{ !request()->has('sort') ? 'selected' : '' }}>Mới nhất</option>
                                    <option value="price_asc" {{ request()->get('sort') == 'price_asc' ? 'selected' : '' }}>Giá từ thấp đến cao</option>
                                    <option value="price_desc" {{ request()->get('sort') == 'price_desc' ? 'selected' : '' }}>Giá từ cao đến thấp</option>
                                </select>

                                {{-- Giữ lại filter khi sort --}}
                                @foreach(request()->except(['sort','page','_token']) as $param => $value)
                                    @if(is_array($value))
                                        @foreach($value as $val)
                                            <input type="hidden" name="{{ $param }}[]" value="{{ $val }}">
                                        @endforeach
                                    @else
                                        <input type="hidden" name="{{ $param }}" value="{{ $value }}">
                                    @endif
                                @endforeach
                            </form>
                        </div>
                    </div>

                    <!-- Product Listing -->
                    <div class="row pb-3">
                        @forelse($products as $product)
                            <div class="col-md-4 mb-4">
                                <div class="card product-card">
                                    <div class="product-image position-relative">
                                        <a href="{{ route('front.product.show', $product->id) }}" class="product-img">
                                            <img class="card-img-top" src="{{ asset('uploads/product/' . $product->image) }}" alt="{{ $product->name }}">
                                        </a>
                                        <a class="whishlist" href="#"><i class="far fa-heart"></i></a>
                                        <div class="product-action">
                                            <!-- Form for adding to cart -->
                                            <form method="POST" action="{{ route('cart.addToCart', ['id' => $product->id]) }}" class="add-to-cart-form d-inline" data-product-id="{{ $product->id }}">
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
                                            <span class="h5"><strong>{{ number_format($product->price) }} VND</strong></span>
                                            @if($product->old_price)
                                                <span class="h6 text-underline"><del>{{ number_format($product->old_price) }} VND</del></span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12">
                                <p>Không tìm thấy sản phẩm nào.</p>
                            </div>
                        @endforelse
                    </div>

                    <!-- Pagination -->
                    <div class="mt-4">
                        {!! $products->appends(request()->all())->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </section>
</section>

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css"/>

<script>
document.querySelectorAll('.add-to-cart-form').forEach(form => {
    form.addEventListener('submit', function (e) {
        e.preventDefault(); // Ngừng reload trang

        const productId = form.getAttribute('data-product-id');
        const quantity = form.querySelector('input[name="quantity"]').value;

        // Tạo đối tượng FormData để gửi dữ liệu giống như submit form thật
        const formData = new FormData();
        formData.append('quantity', quantity);
        formData.append('_token', '{{ csrf_token() }}');

        // Gửi yêu cầu AJAX
        fetch(`/add-to-cart/${productId}`, {
            method: 'POST',
            headers: {
                'Accept': 'application/json'
            },
            body: formData
        })
        .then(response => response.json()) // Đọc phản hồi dưới dạng JSON
        .then(data => {
            // Nếu thêm vào giỏ thành công
            if (data.success) {
                toastr.success(data.success); // Hiển thị thông báo thành công
                const cartCountElement = document.getElementById('cart-count');
                if (cartCountElement) {
                    cartCountElement.textContent = data.cartCount; // Cập nhật số lượng giỏ hàng
                }
            } else {
                toastr.error(data.error || 'Thêm sản phẩm thất bại!');
            }
        })
        .catch(error => {
            toastr.error('Lỗi khi thêm vào giỏ hàng!');
            console.error(error);
        });
    });
});

</script>
@endsection

@endsection
