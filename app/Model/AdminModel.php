<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AdminModel extends Model
{
    public function fetch_single_query($query){
        return DB::select($query);
    }
    public function fetch_all_query($query){
        return DB::select($query);
    }
    public function update_query($query){
        return DB::update($query);
    }

    public function delete_query($query){
        return DB::delete($query);
    }
}
