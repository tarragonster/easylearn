<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Like;
use Illuminate\Support\Facades\Auth;
use App\imagePost;
use App\User;
use App\Comment;

class PagesController extends Controller
{


    public function index(){

        $defs=['','','','',''];
        $display='';
        $spelling='';
        $type='';
        $example=['','','','',''];
        $selectOption='E';
        $q ='';

        $posts = DB::table('image_posts')->orderBy('created_at','desc')->paginate(6);

        $videos = DB::table('videos')->orderBy('created_at','desc')->limit(5)->get();

//        $comments = imagePost::all();
//
//        foreach($comments as $comment){
//
//            $comment->theCom = $comment->comment->count();
//
//        }

        foreach ($posts as $post){

            $post->sumComment = Comment::GetById($post->id,true);
            $post->sumLike = Like::GetById($post->id,true);
            $post->user = User::GetById($post->user_id,true);

            if(Auth::check()){
                $post->allLike = Like::GetCurrentLike($post->id,true);
            }
        }

//        dd($posts);

        foreach ($videos as $video){

            $video->sumLike = Like::GetById($video->id,true);
            $video->user = User::GetById($video->user_id,true);

            if(Auth::check()){
                $video->allLike = Like::GetCurrentLike($video->id,true);
            }
        }

        return view('pages.index')->with('defs', $defs)->with('display',$display)
            ->with('spelling',$spelling)->with('type',$type)->with('example',$example)
            ->with('selectOption',$selectOption)->with('q',$q)->with('posts',$posts)->with('videos',$videos);
    }

    public function fetch_data(Request $request){

        if($request->ajax()){
            $posts = DB::table('image_posts')->orderBy('created_at','desc')->paginate(6);

            foreach ($posts as $post){

                $post->sumComment = Comment::GetById($post->id,true);
                $post->sumLike = Like::GetById($post->id,true);
                $post->user = User::GetById($post->user_id,true);

                if(Auth::check()){
                    $post->allLike = Like::GetCurrentLike($post->id,true);
                }
            }

            return view('pages.article-data')->with('posts',$posts);
        }
    }

}
