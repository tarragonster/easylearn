<?php

namespace App\Providers;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;
use App\Search;
use App\User;

class ComposerServiceProvider extends ServiceProvider
{

    public function boot()
    {
        view()->composer('inc.sidebar', function($view){
            if (Auth::check()) {
                $sidebars = DB::table('searches')->where('user_id', Auth::user()->id)->select('list')->distinct()->get();

                foreach ($sidebars as $sidebar){

                    $sidebar->sumClick = DB::table('searches')->where('list',$sidebar->list)->where('user_id',Auth::user()->id)->sum('clicked');
                }

                $view->with('sidebars', $sidebars);
            }else{
                $view->with('sidebars', null);
            }

            $defs=['','','','',''];
            $display='';
            $spelling='';
            $type='';
            $example=['','','','',''];
            $selectOption='E';
            $q ='';

            $view->with('defs', $defs)->with('display',$display)
                ->with('spelling',$spelling)->with('type',$type)->with('example',$example)
                ->with('selectOption',$selectOption)->with('q',$q);
        });
    }
}
