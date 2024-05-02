<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'item';
    protected $fillable = [
        'item',
        'category',
        'item_code',
        'item_price',
        'item_description',
        'unit_of_measurement',
    ];
    
    public function category_dtls(){   
        return $this->belongsTo(ItemCategory::class, 'category');
    }

    public function unit_of_measurement_dtls(){   
        return $this->belongsTo(Uom::class, 'unit_of_measurement');
    }

}
