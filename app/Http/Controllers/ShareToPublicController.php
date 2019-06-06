<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;
use App\PublicList;


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

        $linkLists = PublicList::orderBy('created_at','desc')->paginate(3);


        if($request->ajax()){

            return [
                'public' => view('practices.ajax-public-part')->with('linkLists',$linkLists)->with('n',$n)->render(),
                'next_page' => $linkLists->nextPageUrl()
            ];

        }

        return view('practices.public')->with('defs', $defs)->with('display',$display)
            ->with('spelling',$spelling)->with('type',$type)->with('example',$example)
            ->with('selectOption',$selectOption)->with('q',$q)->with('n',$n)->with('linkLists',$linkLists);
    }

    public function delete(Request $request){

        $id = $request->input('id');

        $delPublic = DB::table('public_lists')->where('id',$id);

        $userId = $delPublic->value('user_id');

        $list = $delPublic->value('list_name');

        $share = DB::table('searches')->where('user_id',$userId)->where('list',$list)->update(['shared'=>0]);

        $delPublic->delete();

    }
}
