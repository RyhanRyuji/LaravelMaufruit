<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UploadProduct extends Model
{
    // use HasFactory;
    public $timestamps = false;
    protected $table = 'product_info';
    protected $primaryKey ='id';


    protected $fillable = [
        'name',
        'description',
        'unitMeasure',
        'imgPath'
    ];
}
