<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sms extends Model
{
    use HasFactory;
    protected $fillable=[
        'user_id',
        'sms_id',
        'number',
        'sms',
        'count',
        'status',
        'created_at',
        'updated_at',
        'deleted_at',
        'platforms',
        'tel_id',
        'api'

    ];
        
}
