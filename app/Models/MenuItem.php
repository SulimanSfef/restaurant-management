<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'price', 'description', 'category_id', 'image'];

    /**
     * علاقة عنصر القائمة مع الفئة (Category)
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * علاقة عنصر القائمة مع عناصر الطلب (OrderItems)
     */
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
