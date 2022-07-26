<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $table = 'cart';
    protected $fillable = [
        'id',
        'quantity',
        'user_id',
        'prod_id'
    ];
    public $timestamps = false;

    
}
