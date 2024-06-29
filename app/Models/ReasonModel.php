<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReasonModel extends Model
{
    use HasFactory;
    protected $table = 'reject_reason';
    protected $fillable = [
       'reason',
       'user_id',
       'request_id'
    ];
}
