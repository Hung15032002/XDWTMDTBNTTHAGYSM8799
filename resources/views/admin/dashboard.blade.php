@extends('admin.layout.app')

@section('content')

<section class="content-header">					
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Trang chủ</h1>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="container-fluid">
        <div class="row">

            <!-- Tổng sản phẩm -->
            <div class="col-lg-4 col-6">							
                <div class="small-box card bg-primary text-white">
                    <div class="inner">
                        <h3>{{ $totalProducts }}</h3>
                        <p>Tổng sản phẩm</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-pricetag"></i>
                    </div>
                    <a href="{{ url('/admin/products') }}" class="small-box-footer text-white">Xem thêm <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <!-- Tổng đơn hàng -->
            <div class="col-lg-4 col-6">							
                <div class="small-box card bg-danger text-white">
                    <div class="inner">
                        <h3>{{ $totalOrders }}</h3>
                        <p>Tổng đơn hàng</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <a href="{{ url('/admin/orders') }}" class="small-box-footer text-white">Xem thêm <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <!-- Số dư hiện tại -->
            <div class="col-lg-4 col-6">							
                <div class="small-box card bg-secondary text-white">
                    <div class="inner">
                        <h3>{{ $currentBalance }}</h3>
                        <p>Số dư hiện tại</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-cash"></i>
                    </div>
                    <a href="{{ route('gmail.list') }}" class="small-box-footer text-white">Xem thêm <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <!-- Tổng nhãn hàng -->
            <div class="col-lg-4 col-6 mt-3">							
                <div class="small-box card bg-info text-white">
                    <div class="inner">
                        <h3>{{ $totalBrands }}</h3>
                        <p>Tổng nhãn hàng</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-pricetags"></i>
                    </div>
                    <a href="{{ url('/admin/brands') }}" class="small-box-footer text-white">Xem thêm <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <!-- Tổng danh mục sản phẩm -->
            <div class="col-lg-4 col-6 mt-3">							
                <div class="small-box card bg-success text-white">
                    <div class="inner">
                        <h3>{{ $totalCategories }}</h3>
                        <p>Tổng danh mục sản phẩm</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-folder"></i>
                    </div>
                    <a href="{{ url('/admin/categories') }}" class="small-box-footer text-white">Xem thêm <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <!-- Tổng loại sản phẩm (danh mục con) -->
            <div class="col-lg-4 col-6 mt-3">							
                <div class="small-box card bg-warning text-white">
                    <div class="inner">
                        <h3>{{ $totalSubcategories }}</h3>
                        <p>Tổng loại sản phẩm</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-ios-list"></i>
                    </div>
                    <a href="{{ url('/admin/subcategories') }}" class="small-box-footer text-white">Xem thêm <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

        </div>
    </div>
</section>

@endsection

@section('customjs')
@endsection
