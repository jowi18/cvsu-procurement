<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PmppCategories extends Model
{
    use HasFactory;
    protected $table = 'pmpp_categories';

    public function category_type_dtls(){
        return $this->belongsTo(PmppCategoryType::class, 'category_type');
    }
}
