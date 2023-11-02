<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BloodRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'recipient_name',
        'gender',
        'age',
        'blood_group_id',
        'city_id',
        'contact_no',
        'address',
        'hospital_name',
        'sender_id',
        'status',
        'donor_id'
    ];
}
