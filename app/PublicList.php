<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PublicList extends Model
{
    protected $table='public_lists';
    public $primaryKey='id';
    public $timestamps='true';

    public function user(){
        return $this->belongsTo('App\User');
    }
}
