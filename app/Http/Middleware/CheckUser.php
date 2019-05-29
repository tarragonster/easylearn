<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use Closure;

class CheckUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $id = $request->route()->parameter('userId');

        $list = $request->route()->parameter('list');

        $checkShare = DB::table('searches')->where('list',$list)->where('user_id',$id)->sum('shared');

        if($checkShare == 0){
            if(Auth::check() && $id == Auth::user()->id){
                return $next($request);
            }
            return redirect()->to('/');
        }else{
            return $next($request);
        }
    }
}
