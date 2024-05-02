<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PurchaseRequestHeader extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'purchase_request_hdr';
    protected $fillable = [
        'created_by',
        'department_id',
        'approved_by',
        'for_approval',
        'rejected_by',
        'purpose',
        'signature',
        'pr_code',
        'status'
    ];

    public function pr_dtls(){
        return $this->hasMany(PurchaseRequestDetails::class,'pr_hdr_id');
    }
    public function created_by_dtls(){
        return $this->belongsTo(User::class,'created_by');
    }

    public function approved_by_dtls(){
        return $this->belongsTo(User::class,'approved_by');
    }

    public function rejected_by_dtls(){
        return $this->belongsTo(User::class,'rejected_by');
    }

    public function for_approval_dtls(){
        return $this->belongsTo(User::class,'for_approval');
    }

    public function department_dtls(){
        return $this->belongsTo(Department::class,'department_id');
    }

    public function status_dtls(){
        return $this->belongsTo(Status::class,'status');
    }

}
