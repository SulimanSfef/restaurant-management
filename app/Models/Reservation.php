<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $casts = [
    'booked_slots' => 'array',
    'date' => 'date',
];


  protected $fillable = [
    'user_id',
    'customer_name',
    'phone',
    'guest_count',
    'table_id',
    'booked_slots',
    'date',
    'status',
    'notes',
];

    /**
     * علاقة الحجز مع الطاولة (Table)
     */
    public function table()
    {
        return $this->belongsTo(Table::class);
    }

    public function user()
{
    return $this->belongsTo(User::class);
}
}
