<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Barang extends Model
{
    protected $table = 'barang';
    use SoftDeletes;
    public function categories(){
        return $this->belongsToMany('App\Category');
    }
    
}
