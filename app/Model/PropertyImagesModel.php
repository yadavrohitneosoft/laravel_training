<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class PropertyImagesModel extends Model
{
    protected $table = 'property_images';
    protected $fillable = ['prop_id','image'];
    
    //Explanation -
    //By default, Eloquent expects created_at and updated_at columns to exist on your tables. If you do not wish to have these columns automatically managed by Eloquent, set the $timestamps property on your model to false
    public $timestamps = false;

}
