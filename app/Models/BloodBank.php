<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BloodBank extends Model
{
    use HasFactory;

    protected $table = 'bloodbank';

    protected $fillable = [
        'id',
        'quantity',
        'blood_group_id',
        'city_id',
    ];
}
