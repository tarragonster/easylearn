<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Post;
use Illuminate\Support\Facades\Input;
use Illuminate\Validation\Rules\In;
use App\Search;
use Illuminate\Support\Facades\Auth;
use App\PublicList;

class PracticeController extends Controller
{
    public function index($list,$userId){

        $defs=['','','','',''];
        $display='';
        $spelling='';
        $type='';
        $example=['','','','',''];
        $selectOption='E';
        $q ='';
        $n = 0;

        $contentLists = DB::table('searches')->where('list',$list)->where('user_id',$userId)->get();

        return view('practices.index')->with('defs', $defs)->with('display',$display)
            ->with('spelling',$spelling)->with('type',$type)->with('example',$example)
            ->with('selectOption',$selectOption)->with('q',$q)->with('contentLists',$contentLists)->with('n',$n);

    }

    public function display($id){

        $onclickWord = DB::table('searches')->where('id',$id)->get();


        return response($onclickWord);
    }

    public function destroy(Request $request){

        $getId = $request->input('getId');

        $search = DB::table('searches')->where('id',$getId);

        $nameWord =$search->value('word');

        $nameList = $search->value('list');

        $countList = DB::table('searches')->where('list',$nameList)->count();

        if($countList===1){

            $searches = new Search;
            $searches->word ='';
            $searches->definition ='';
            $searches->type ='';
            $searches->pronunciation ='';
            $searches->example ='';
            $searches->list =$nameList;
            $searches->language ='';
            $searches->update_image ='';
            $searches->user_id = Auth::user()->id;
            $searches->checked = 0;

            $searches->save();
            $search->delete();
        }else{
            $search->delete();
        }

        return response($nameWord);
    }

    public function deleteList(Request $request){

        $nameList = $request->input('nameList');

        $list = DB::table('searches')->where('list',$nameList);

        $list->delete();

        return response($nameList);
    }

    public function restartModal(Request $request){
        $nameList = $request->input('nameList');

        $list = DB::table('searches')->where('id',$nameList)->get();

        return response($list);
    }

    public function editModal(Request $request){

        // get the previous path of uploaded images
        $id = $request->input('id');
        $oldFile = DB::table('searches')->where('id',$id)->value('update_image');

        //validate file upload

        $this->validate($request,[
            'update_image' => 'image|nullable|max:1999'
        ]);

        //Handle file upload
        if($request->hasFile('update_image')){
            //Get filename with extension
            $fileNameWithExt = $request->file('update_image')->getClientOriginalName();
            //Get just filename
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            //Get just extension
            $extension = $request->file('update_image')->guessClientExtension();
            //Upload image
            $fileNameToStore = $fileName.'_'.time().'.'.$extension;
            $nameToDisplay = '/storage/update_images/'.$fileNameToStore;
            //Upload images
            $path = $request->file('update_image')->storeAs('public/update_images/',$fileNameToStore);

        }elseif($request->input('URLinputBox') !== null){
            $nameToDisplay = $request->input('URLinputBox');
        }else{
            $nameToDisplay = $oldFile;
        }

        if($request->ajax()){

        $edit = Search::find($id);
        $edit->word = $request->input('word');
        $edit->pronunciation = $request->input('pronunciation');
        $edit->type = $request->input('type');
        $edit->definition = $request->input('definition');
        $edit->example = $request->input('example');
        $edit->update_image = $nameToDisplay;

        $edit->save();

            return response($edit);
        }
    }

    public function checked(Request $request){
        $id = $request->input('wordId');

        $word = Search::find($id);

        $word->checked = $request->input('checked');
        $word->save();

        return response($word);
    }

    public function onload(Request $request){

        $id = $request->input('wordId');

        $checked = DB::table('searches')->where('id',$id)->get();

        return  response($checked);
    }

    public function sumCheck(Request $request){

        $nameList = $request->input('nameList');

        $sumCheck = DB::table('searches')->where('list',$nameList)->sum('checked');

        return response($sumCheck);
    }

    public function reset(Request $request){
        $list = $request->input('theList');

        $word = DB::table('searches')->where('list',$list)->update(['checked'=> 0]);

        return response($word);
    }

    public function share(Request $request){

        $userId = $request->input('id');

        $list = $request->input('list');

        $url = $request->input('url');

        $searchId = DB::table('searches')->where('list',$list)->where('user_id',$userId)->value('id');

        $checkShare = DB::table('searches')->where('list',$list)->where('user_id',$userId)->sum('shared');

        if($checkShare == 0){

            $share = DB::table('searches')->where('list',$list)->where('user_id',$userId)->update(['shared'=>1]);

            $public = new PublicList;

            $public->user_id = $userId;
            $public->post_id = $searchId;
            $public->list_name = $list;
            $public->link = $url;
            $public->save();

        }else{
            $share = DB::table('searches')->where('list',$list)->where('user_id',$userId)->update(['shared'=>0]);

            $publicDel = DB::table('public_lists')->where('list_name',$list)->where('user_id',$userId)->delete();
        }

        return response($checkShare);

//        create new row in ShareToPublic table



    }


    public function checkShare(Request $request){

        $userId = $request->input('id');

        $list = $request->input('list');

        $checkShare = DB::table('searches')->where('list',$list)->where('user_id',$userId)->limit(3)->get();

        return response($checkShare);
    }

    public function clicked(Request $request){

        $listName = $request->input('listName');

        $userId = Auth::user()->id;

        $otherClick = DB::table('searches')->where('user_id',$userId)->update(['clicked'=>0]);

        $clicked = DB::table('searches')->where('list',$listName)->where('user_id',$userId)->update(['clicked'=>1]);

        return response($clicked);
    }

}
