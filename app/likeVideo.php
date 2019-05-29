<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class likeVideo extends Model
{
    //Table name
    protected $table='like_videos';
    //Primary key
    public $primaryKey='id';
    //TimeStamps
    public $timestamps='true';

    public static function GetById($id,$cache=true){
        $key ='CACHE_LIKE_VIDEO_BY_ID_'.$id;
        $data = Cache::store('file')->get($key);
        if(!$data || $cache== false){
            $data = DB::table('like_videos')->where('video_id',$id)->sum('like');
            Cache::store('file')->put($key,$data);
        }
        return $data;
    }

    public static function GetCurrentLike($id,$cache=true){
        $key ='CACHE_GET_CURRENT_LIKE_VIDEO_'.$id;
        $data = Cache::store('file')->get($key);
        if(!$data || $cache== false){
            $data = DB::table('like_videos')->where('video_id',$id)->get();
            Cache::store('file')->put($key,$data);
        }
        return $data;
    }
}
