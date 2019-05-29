<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShareToPublicController extends Controller
{
    public function show(Request $request){
        $defs=['','','','',''];
        $display='';
        $spelling='';
        $type='';
        $example=['','','','',''];
        $selectOption='E';
        $q ='';
        $n = 0;


        return view('practices.public')->with('defs', $defs)->with('display',$display)
            ->with('spelling',$spelling)->with('type',$type)->with('example',$example)
            ->with('selectOption',$selectOption)->with('q',$q)->with('n',$n);
    }
}
