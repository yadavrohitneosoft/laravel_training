<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UserModel extends Model
{
    protected $table = "users"; 
    protected $fillable = [
        'firstname',
        'lastname',
        'user_type',
        'email',
        'status',
        'password',
        'created_at'
    ];
    
    //Explanation -
    //By default, Eloquent expects created_at and updated_at columns to exist on your tables. If you do not wish to have these columns automatically managed by Eloquent, set the $timestamps property on your model to false
    public $timestamps = false;
}
