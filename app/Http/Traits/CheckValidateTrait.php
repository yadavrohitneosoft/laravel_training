<?php
namespace App\Http\Traits; 
use Illuminate\Http\Request;
use Redirect,Response; 
use Illuminate\Support\Facades\Cache; 
use Illuminate\Support\Collection;  
use Illuminate\Support\Facades\Validator;
trait CheckValidateTrait {

    //validate trait
    protected function checkValidator($request, $arr = []){
        return Validator::make($request, $arr);
	} 

}