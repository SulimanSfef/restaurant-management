<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    use HasFactory;

    protected $fillable = ['table_number', 'status','capacity'];

    /**
     * علاقة الطاولة مع الحجوزات (Reservations)
     */
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    /**
     * علاقة الطاولة مع الطلبات (Orders)
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
