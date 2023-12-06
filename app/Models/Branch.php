<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Vehicle;
use App\Models\User;

class Branch extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'location',
        'adresse',
        'company_id',
    ];

    public function company() {
        return $this->belongsTo(User::class, 'company_id', 'id');
    }

    public function vehicles()
    {
        return $this->hasMany(Vehicle::class, 'id', 'pickup_loc');
    }
}
