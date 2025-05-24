@extends('admin.layout.app')

@section('content')

<section class="content-header">					
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Dashboard</h1>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="container-fluid">
        <div class="row">

            <!-- Tổng sản phẩm -->
            <div class="col-lg-4 col-6">							
                <div class="small-box card">
                    <div class="inner">
                        <h3>{{ $totalProducts }}</h3>
                        <p>Tổng sản phẩm</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-pricetag"></i>
                    </div>
                    <a href="{{ url('/admin/products') }}" class="small-box-footer text-dark">Xem thêm <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <!-- Tổng đơn hàng -->
            <div class="col-lg-4 col-6">							
                <div class="small-box card">
                    <div class="inner">
                        <h3>{{ $totalOrders }}</h3>
                        <p>Tổng đơn hàng</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <a href="{{ url('/admin/orders') }}" class="small-box-footer text-dark">Xem thêm <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <!-- Số dư hiện tại -->
            <div class="col-lg-4 col-6">							
                <div class="small-box card">
                    <div class="inner">
                        <h3>{{ $currentBalance }}</h3>
                        <p>Số dư hiện tại</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-cash"></i>
                    </div>
                    <a href="javascript:void(0);" class="small-box-footer">&nbsp;</a>
                </div>
            </div>

        </div>
    </div>
</section>

@endsection

@section('customjs')
@endsection
