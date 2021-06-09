<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class PropertyModel extends Model
{
    protected $table = 'property';
    protected $fillable = ['title','price','floor_area','bedroom','bathroom','city',
    'address','description','nearby'];
    
    //Explanation -
    //By default, Eloquent expects created_at and updated_at columns to exist on your tables. If you do not wish to have these columns automatically managed by Eloquent, set the $timestamps property on your model to false
    public $timestamps = false;

}
