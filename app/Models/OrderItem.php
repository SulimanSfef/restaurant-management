<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = ['order_id', 'menu_item_id', 'quantity', 'note'];

    /**
     * علاقة عنصر الطلب مع الطلب (Order)
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * علاقة عنصر الطلب مع القائمة (MenuItem)
     */
    public function menuItem()
    {
        return $this->belongsTo(MenuItem::class);
    }
}
