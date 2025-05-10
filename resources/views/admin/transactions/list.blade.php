@extends('admin.layout.app')

@section('content')
<div class="container mt-5">
    <h2>Thông báo giao dịch từ Sacombank</h2>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(isset($error))
        <div class="alert alert-danger">
            {{ $error }}
        </div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Ngày</th>
                <th>Phát sinh</th>
                <th>Số dư khả dụng</th>
                <th>Nội dung</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($transactions as $transaction)
                <tr>
                    <td>{{ $transaction['date'] ?? 'N/A' }}</td>
                    <td>{{ $transaction['transaction'] ?? 'N/A' }}</td>
                    <td>{{ $transaction['balance'] ?? 'N/A' }}</td>
                    <td>{{ $transaction['description'] ?? 'N/A' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center text-danger">Không có giao dịch nào từ Sacombank.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
