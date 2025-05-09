@extends('admin.layout.app')

@section('content')
<div class="container mt-5">
    <h2>Danh sách giao dịch</h2>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Tài khoản</th>
                <th>Ngày giao dịch</th>
                <th>Số tiền</th>
                <th>Số dư khả dụng</th>
                <th>Mô tả</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transactions as $transaction)
                <tr>
                    <td>{{ $transaction->account_number }}</td>
                    <td>{{ $transaction->transaction_date->format('d/m/Y H:i') }}</td>
                    <td>{{ number_format($transaction->amount, 0, ',', '.') }} VNĐ</td>
                    <td>{{ number_format($transaction->balance, 0, ',', '.') }} VNĐ</td>
                    <td>{{ $transaction->description }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
