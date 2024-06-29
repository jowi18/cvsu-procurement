<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManageApprovePrModel extends Model
{
    use HasFactory;

    protected $table ='pr_attachment';
    protected $fillable = [
        'pr_hdr_id',
        'attachment',

    ];
}
