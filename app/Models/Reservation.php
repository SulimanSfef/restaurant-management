<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = ['customer_name', 'phone', 'table_id', 'reserved_at', 'status', 'notes'];

    /**
     * علاقة الحجز مع الطاولة (Table)
     */
    public function table()
    {
        return $this->belongsTo(Table::class);
    }
}
