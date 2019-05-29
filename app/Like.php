<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class Like extends Model
{
    //Table name
    protected $table='likes';
    //Primary key
    public $primaryKey='id';
    //TimeStamps
    public $timestamps='true';

    public static function GetById($id,$cache=true){
        $key ='CACHE_LIKE_BY_ID_'.$id;
        $data = Cache::store('file')->get($key);
        if(!$data || $cache== false){
            $data = DB::table('likes')->where('imagePost_id',$id)->sum('like');
            Cache::store('file')->put($key,$data);
        }
        return $data;
    }

    public static function GetCurrentLike($id,$cache=true){
        $key ='CACHE_GET_CURRENT_LIKE_'.$id;
        $data = Cache::store('file')->get($key);
        if(!$data || $cache== false){
            $data = DB::table('likes')->where('imagePost_id',$id)->get();
            Cache::store('file')->put($key,$data);
        }
        return $data;
    }
}
