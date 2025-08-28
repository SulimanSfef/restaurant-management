<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    use HasFactory;

      protected $fillable = [
        'menu_item_id',
        'title',
        'description',
        'discount_percentage',
        'new_price',
        'image',
        'start_date',
        'end_date',
        'is_active',
    ];

      public function menuItem()
    {
        return $this->belongsTo(MenuItem::class, 'menu_item_id');
    }
}
