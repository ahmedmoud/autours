<?php

namespace App\Models;
use App\Models\Vehicle;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rental extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'order_status',
        'order_number',
        'vehicle_id',
        'price',
        'start_date',
        'end_date',
        'start_time',
        'end_time',
    ];

    public function vehicle() {
        return $this->belongsTo(Vehicle::class, 'vehicle_id', 'id');
    }

}
