<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Customer_seller extends Authenticatable
{
    use HasFactory;
    use Notifiable;

    protected $table = 'customer_seller'; 
    
    protected $fillable = [
        'name', 'email', 'password' , 'type','nic','address','phone',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function wishlist()
    {
        return $this->hasMany(Wishlist::class, 'user_ID');
    }

}
