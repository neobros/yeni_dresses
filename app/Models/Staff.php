<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Staff extends Authenticatable
{
    use HasFactory;
    use Notifiable;

    protected $table = 'staff'; 
    
    protected $fillable = [
        'name', 'email', 'password' , 'role', 'join_date','nic','address','phone',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];
}
