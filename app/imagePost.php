<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class imagePost extends Model
{
    protected $table='image_posts';
    public $primaryKey='id';
    public $timestamps='true';

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function comment(){
        return $this->hasMany('App\Comment','imagePost_id');
    }
}
