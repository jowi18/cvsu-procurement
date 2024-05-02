<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PmppHeader extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'pmpp_hdr';
    protected $fillable = [
        'project',
        'prepared_by',
        'department',
        'fund_source',
        'budget',
        'year',
        'status',
        'description',
        'rejected_by',
        'approved_by',
    ];

    public function pmpp_dtls(){
        return $this->hasMany(PmppDetails::class, 'pmpp_hdr_id');
    }

    public function prepared_by_dtls(){
        return $this->belongsTo(User::class, 'prepared_by');
    }

    public function department_dtls(){
        return $this->belongsTo(Department::class, 'department');
    }

    public function status_dtls(){
        return $this->belongsTo(Status::class, 'status');
    }

    public function fund_dtls(){
        return $this->belongsTo(FundSource::class, 'fund_source');
    }

   
}
