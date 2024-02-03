<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Included extends Model
{
    protected $table = 'included';
    public $timestamps = true;
    protected $fillable = ['what_is_included'];
    use HasFactory;
}
