<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notifications extends Model
{
    use HasFactory;

    protected $table = 'notification';
    protected $fillable = [
        'transact_by',
        'belong_to',
        'title',
        'message_to_creator',
        'message_to_others',
        'read_at',
        'department'
    ];

    public function transactBy_dtls(){
        return $this->belongsTo(User::class, 'transact_by');
    }

    public function belongTo_dtls(){
        return $this->belongsTo(User::class, 'belong_to');
    }
}
