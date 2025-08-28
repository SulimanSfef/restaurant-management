<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'table_id', 'address_id', 'status','final_price'];


    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function table()
    {
        return $this->belongsTo(Table::class);
    }

      public function items()
    {
        return $this->hasMany(OrderItem::class);
    }



    // العلاقة مع عنوان التوصيل (إذا الطلب ديلفري)
    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    /**
     * علاقة الطلب مع الفاتورة (Invoice)
     */
    public function invoice()
    {
        return $this->hasOne(Invoice::class);
    }
}
