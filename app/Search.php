<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Search extends Model
{
    protected $table='searches';
    public $primaryKey='id';
    public $timestamps='true';

    public function user(){
        return $this->belongsTo('App\User');
    }
}
