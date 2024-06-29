<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OtpModel extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'otp';
    protected $fillable = [
        'otp',
        'request_id',
        'user_id'
    ];
}
