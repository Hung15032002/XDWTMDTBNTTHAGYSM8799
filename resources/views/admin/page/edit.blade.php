@extends('admin.layout.app')

@section('content')
<div class="container mt-5">
    <h2>Cập nhật thông tin liên hệ</h2>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('pages.update', $page->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="facebook_link" class="form-label">Link Facebook</label>
            <input type="url" class="form-control @error('facebook_link') is-invalid @enderror" id="facebook_link" name="facebook_link" value="{{ old('facebook_link', $page->facebook_link) }}">
            @error('facebook_link')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="zalo_link" class="form-label">Link Zalo</label>
            <input type="url" class="form-control @error('zalo_link') is-invalid @enderror" id="zalo_link" name="zalo_link" value="{{ old('zalo_link', $page->zalo_link) }}">
            @error('zalo_link')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="address" class="form-label">Địa chỉ</label>
            <input type="text" class="form-control @error('address') is-invalid @enderror" id="address" name="address" value="{{ old('address', $page->address) }}">
            @error('address')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="phone_numbers" class="form-label">Số điện thoại</label>
            <div id="phone_numbers_wrapper">
                @php
                    // Lấy giá trị cũ từ form submit hoặc dữ liệu trong database
                    $phones = old('phone_numbers', json_decode($page->phone_numbers ?? '[]', true));
                @endphp

                @foreach ($phones as $phone)
                    <div class="input-group mb-3 phone-input-group">
                        <input type="text" class="form-control" name="phone_numbers[]" value="{{ $phone }}" placeholder="Số điện thoại">
                        <button type="button" class="btn btn-danger remove-phone">Xóa</button>
                    </div>
                @endforeach
            </div>
            {{-- <button type="button" class="btn btn-primary" id="add-phone">Thêm số điện thoại</button>
            @error('phone_numbers.*')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror --}}
        </div>

        <button type="submit" class="btn btn-success">Cập nhật</button>
        <a href="{{ route('pages.index') }}" class="btn btn-secondary">Thoát</a>
    </form>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Thêm số điện thoại mới
        document.getElementById('add-phone').addEventListener('click', function() {
            var wrapper = document.getElementById('phone_numbers_wrapper');
            var newPhoneField = document.createElement('div');
            newPhoneField.classList.add('input-group', 'mb-3', 'phone-input-group');
            newPhoneField.innerHTML = `
                <input type="text" class="form-control" name="phone_numbers[]" placeholder="Số điện thoại">
                <button type="button" class="btn btn-danger remove-phone">Xóa</button>
            `;
            wrapper.appendChild(newPhoneField);

            // Gán sự kiện Xóa cho các nút xóa mới
            newPhoneField.querySelector('.remove-phone').addEventListener('click', function() {
                newPhoneField.remove();
            });
        });

        // Gán sự kiện xóa cho các số điện thoại hiện có
        document.querySelectorAll('.remove-phone').forEach(function(button) {
            button.addEventListener('click', function() {
                button.parentElement.remove();
            });
        });
    });
</script>
@endsection
