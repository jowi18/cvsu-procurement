<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PurchaseRequestDetails extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'purchase_request_dtls';
    protected $fillable = [
        'item_id',
        'quantity',
        'price',
        'pr_hdr_id',
        'image'
    ];

    public function item_dtls(){
        return $this->belongsTo(Item::class, 'item_id');
    }


}
