<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $table = 'item';

    protected $fillable = [
        'category_ID',
        'name',
        'size',    
        'price',    
        'description',    
        'photo',
        'quantity',
        'seller_ID',
        'click_count'
    ];
}
