<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    // use HasFactory;
    public $timestamps = false;
    protected $table = 'usercontact_info';
    protected $primaryKey ='id';

    protected $fillable = [
        'addressLine',
        'city',
        'contactNumber',
        'user_id'
    ];

}
