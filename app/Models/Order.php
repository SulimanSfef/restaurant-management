<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'table_id', 'status'];

    /**
     * علاقة الطلب مع المستخدم (User)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * علاقة الطلب مع الطاولة (Table)
     */
    public function table()
    {
        return $this->belongsTo(Table::class);
    }

    /**
     * علاقة الطلب مع عناصر الطلب (Order Items)
     */
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * علاقة الطلب مع الفاتورة (Invoice)
     */
    public function invoice()
    {
        return $this->hasOne(Invoice::class);
    }
}
