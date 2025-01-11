<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    use HasFactory;

    protected $table = 'delivery';
    protected $primaryKey = 'delivery_ID';

    // Indicates if the IDs are auto-incrementing
    public $incrementing = true;

    // The data type of the auto-incrementing ID
    protected $keyType = 'int';
    protected $fillable = [
        'type',
        'address',
        'date',    
    ];
}
