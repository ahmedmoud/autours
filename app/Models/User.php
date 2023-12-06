<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Vehicle;
use App\Models\Branch;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'logo',
        'name',
        'company',
        'gender',
        'country',
        'address',
        'email',
        'phone_num',
        'password',
        'role',
        'price_tax',
        'week_price_tax',
        'month_price_tax',
        'year_price_tax'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function vehicles() {
        return $this->hasMany(Vehicle::class, 'id', 'supplier');
    }

    public function branches()
    {
        return $this->hasMany(Branch::class, 'id', 'company_id');
    }
}
