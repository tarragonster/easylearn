<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class commentVid extends Model
{
    //Table name
    protected $table='comment_vids';
    //Primary key
    public $primaryKey='id';
    //TimeStamps
    public $timestamps='true';

    public static function GetById($id,$cache=true){
        $key ='CACHE_COMMENT_VIDEO_BY_ID_'.$id;
        $data = Cache::store('file')->get($key);
        if(!$data || $cache== false){
            $data = DB::table('comment_vids')->where('video_id',$id)->count();
            Cache::store('file')->put($key,$data);
        }
        return $data;
    }
}
