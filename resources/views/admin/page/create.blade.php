@extends('admin.layout.app')

@section('content')
<div class="container mt-5">
    <h2>Thêm thông tin liên hệ</h2>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('pages.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="facebook_link" class="form-label">Link Facebook</label>
            <input type="url" class="form-control @error('facebook_link') is-invalid @enderror" id="facebook_link" name="facebook_link" value="{{ old('facebook_link') }}">
            @error('facebook_link')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="zalo_link" class="form-label">Link Zalo</label>
            <input type="url" class="form-control @error('zalo_link') is-invalid @enderror" id="zalo_link" name="zalo_link" value="{{ old('zalo_link') }}">
            @error('zalo_link')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="address" class="form-label">Địa chỉ</label>
            <input type="text" class="form-control @error('address') is-invalid @enderror" id="address" name="address" value="{{ old('address') }}">
            @error('address')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="phone_numbers" class="form-label">Số điện thoại</label>
            <div id="phone_numbers_wrapper">
                <div class="input-group mb-3 phone-input-group">
                    <input type="text" class="form-control" name="phone_numbers[]" placeholder="Số điện thoại">
                    <button type="button" class="btn btn-danger remove-phone">Xóa</button>
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-success">Thêm mới</button>
    </form>
</div>
@endsection
