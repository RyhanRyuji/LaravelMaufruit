<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Productsinfo extends Model
{
   
    protected $table = 'productsinfo';
    protected $fillable = [
        'product_id',
        'name',
        'description',
        'unitMeasure',
        'imgPath',
        'grade',
        'sellingPrice',
        'numInStock'
    ];
    public $timestamps = false;

}
