<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'user_image'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function searches(){
        return $this->hasMany('App\Search');
    }

    public function imagePost(){
        return $this->hasMany('App\imagePost');
    }

    public static function GetById($id,$cache=true){
        $key ='CACHE_USER_BY_ID_'.$id;
        $data = Cache::store('file')->get($key);
        if(!$data || $cache== false){
            $data = DB::table('users')->where('id',$id)->get();
            Cache::store('file')->put($key,$data);
        }
        return $data;
    }
}
