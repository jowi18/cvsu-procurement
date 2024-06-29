<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManageLogs extends Model
{
    use HasFactory;
    protected $table ='logs';
    protected $fillable = [
        'user_id',
        'action',
    ];

    public function user_dtls(){
        return $this->belongsTo(User::class, 'user_id');
    }
}
