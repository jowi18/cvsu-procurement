<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PmppDetails extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'pmpp_dtls';
    protected $fillable = [
        'pmpp_hdr_id',
        'item_category',
        'item_name',
        'unit_of_measurement',
        'item_quantity',
        'item_description',
        'item_amount'
    ];

    public function item_category_dtls(){
        return $this->belongsTo(ItemCategory::class, 'item_category');
    }

    public function item_name_dtls(){
        return $this->belongsTo(Item::class, 'item_name');
    }

    public function item_name_dtls1(){
        return $this->hasOne(Item::class, 'item_name');
    }

    public function unit_of_measurement_dtls(){
        return $this->belongsTo(Uom::class, 'unit_of_measurement');
    }
}
