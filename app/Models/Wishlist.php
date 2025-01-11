<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    use HasFactory;

    protected $table = 'wishlist'; 

    protected $fillable = [
        'user_ID', 
        'item_ID',
        'created_at',
    ];

    public function user()
    {
        return $this->belongsTo(Customer_seller::class, 'user_ID');
    }

    public function item()
    {
        return $this->belongsTo(Item::class, 'item_ID'); 
    }
}
