<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'payment_method',
        'total',
        'deposit',
        'ordered_at',
        'status', // Đảm bảo rằng status là một trường có trong bảng `orders`
    ];

    // Các trạng thái đơn hàng
    const STATUS_PENDING = 'chua_xac_nhan';
    const STATUS_CONFIRMED = 'da_xac_nhan';
    const STATUS_SHIPPING = 'dang_van_chuyen';
    const STATUS_COMPLETED = 'hoan_thanh';
    const STATUS_CANCELLED = 'huy'; // Trạng thái hủy

    // Quan hệ với bảng OrderItem
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Đặt trạng thái mặc định
    public function getStatusAttribute($value)
    {
        // Các trạng thái được chuyển sang tiếng Việt
        $statusLabels = [
            self::STATUS_PENDING => 'Chờ xử lý',  // Đổi từ 'Chưa xác nhận' thành 'Chờ xử lý'
            self::STATUS_CONFIRMED => 'Đã xác nhận',
            self::STATUS_SHIPPING => 'Đang vận chuyển',
            self::STATUS_COMPLETED => 'Hoàn thành',
            self::STATUS_CANCELLED => 'Đã hủy',
        ];

        // Trả về giá trị tiếng Việt của trạng thái nếu có, ngược lại trả về giá trị mặc định
        return $statusLabels[$value] ?? ucfirst(str_replace('_', ' ', $value));
    }


}
