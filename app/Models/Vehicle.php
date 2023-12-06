<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use App\Models\Rental;
use App\Models\Branch;
use App\Models\VehiclesPhotos;
use App\Models\User;

class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = [
        'photo',
        'name',
        'supplier',
        'price',
        'week_price',
        'month_price',
        'year_price',
        'pickup_loc',
        'start_date',
        'end_date',
        'category',
        'specifications',
        'description',
    ];

    protected $casts = [
        'specifications' => 'array'
    ];

    public function category() {
        return $this->belongsTo(Category::class, 'category', 'id');
    }

    public function supplier() {
        return $this->belongsTo(User::class, 'supplier', 'id');
    }

    public function branch() {
        return $this->belongsTo(Branch::class, 'pickup_loc', 'id');
    }

    public function rentals(){
        return $this->hasMany(Rental::class, 'vehicle_id', 'id');
    }
}
