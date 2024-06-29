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
        'main_category',
        'sub_category_a',
        'sub_category_b',
        'sub_category_c',
        'uacs_code',
        'code',
        'forwarded_by',
        'reviewed_by'
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

    public function main_category_dtls(){
        return $this->belongsTo(PmppCategories::class, 'main_category');
    }

    public function sub_category_a_dtls(){
        return $this->belongsTo(PmppCategories::class, 'sub_category_a');
    }

    public function sub_category_b_dtls(){
        return $this->belongsTo(PmppCategories::class, 'sub_category_b');
    }

    public function sub_category_c_dtls(){
        return $this->belongsTo(PmppCategories::class, 'sub_category_c');
    }
    
    public function reviewed_by_dtls(){
        return $this->belongsTo(User::class,'reviewed_by');
    }

    public function forwarded_by_dtls(){
        return $this->belongsTo(User::class,'forwarded_by');
    }

    public function approved_by_dtls(){
        return $this->belongsTo(User::class,'approved_by');
    }
}
