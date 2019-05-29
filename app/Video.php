<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    protected $table='videos';
    public $primaryKey='id';
    public $timestamps='true';

    public function user(){
        return $this->belongsTo('App\User');
    }
}
