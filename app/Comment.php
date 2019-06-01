<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class Comment extends Model
{
    //Table name
    protected $table='comments';
    //Primary key
    public $primaryKey='id';
    //TimeStamps
    public $timestamps='true';

    public static function GetById($id,$cache=true){
        $key ='CACHE_COMMENT_BY_ID_'.$id;
        $data = Cache::store('file')->get($key);
        if(!$data || $cache== false){
            $data = DB::table('comments')->where('imagePost_id',$id)->count();
            Cache::store('file')->put($key,$data);
        }
        return $data;
    }

    public function imagePost(){

        return $this->belongsTo('App\imagePost' ,'imagePost_id');
    }
}
