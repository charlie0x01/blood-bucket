<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BloodRequest extends Model
{
    use HasFactory;

    const REQ_PENDING = 'pending';
    const REQ_ACCEPTED = 'accepted';
    const REQ_APPROVED = 'approved';
    const REQ_REJECTED = 'rejected';
    const REQ_FULFILLED = 'fulfilled';

    protected $fillable = [
        'id',
        'recipient_name',
        'blood_group_id',
        'city_id',
        'age',
        'gender',
        'contact_no',
        'address',
        'hospital_name',
        'sender_id',
        'donor_id',
        'request_state',
        'approved_by',
        'emergency_flag',
        'need_on'
    ];

}
