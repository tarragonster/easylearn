<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class PublicList extends Model
{
    protected $table='public_lists';
    public $primaryKey='id';
    public $timestamps='true';

    public function user(){
        return $this->belongsTo('App\User','user_id');
    }

    public function search(){
        return $this->hasMany('App\Search','list','list_name')->where('user_id',$this->user_id);
    }
}
