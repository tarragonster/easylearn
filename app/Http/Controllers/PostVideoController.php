<?php

namespace App\Http\Controllers;

use App\commentVid;
use App\likeVideo;
use App\Providers\CacheLog;
use App\Providers\TranslateFree;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Royalmar\HtmlDomParser\HtmlDomParser;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Video;


class PostVideoController extends Controller
{
    public function store(Request $request){

        $n = 0;

        $youtubeLink = $request->input('youtube');
        $iframeLink = $request->input('iframe');

        if($youtubeLink !== null){
            $nameToDisplay = $youtubeLink;
        }else if($iframeLink !== null){
            $nameToDisplay = $iframeLink;
        }else{
            $nameToDisplay = '<img class="postImg" src="/storage/update_images/no_video.jpg" alt="">';
        }

        if($request->ajax()){

            $videoPost = new Video;
            $videoPost->title =$request->input('title');
            $videoPost->description =$request->input('desc');
            $videoPost->video=$nameToDisplay;
            $videoPost->user_id = Auth::user()->id;


            $videoPost->save();

            $videoPosts = DB::table('videos')->orderBy('updated_at','desc')->get();

            foreach ($videoPosts as $key=>$value){

                $videoPosts[$key]->sumComment = commentVid::GetById($value->id,true);
                $videoPosts[$key]->user = User::GetById($value->user_id,true);
                $videoPosts[$key]->sumLike = likeVideo::GetById($value->id,true);

                if(Auth::check()){
                    $videoPosts[$key]->allLike = likeVideo::GetCurrentLike($value->id,true);
                }
            }

            return view('postVideos.posting-part')->with('videoPosts',$videoPosts)->with('n',$n);
        }
    }

    public function show(Request $request){
        $defs=['','','','',''];
        $display='';
        $spelling='';
        $type='';
        $example=['','','','',''];
        $selectOption='E';
        $q ='';
        $n = 0;

        $videoPosts = DB::table('videos')->orderBy('updated_at','desc')->paginate(2);

        foreach ($videoPosts as $key=>$value){
            $videoPosts[$key]->sumComment = commentVid::GetById($value->id,true);
            $videoPosts[$key]->user = User::GetById($value->user_id,true);
            $videoPosts[$key]->sumLike = likeVideo::GetById($value->id,true);

            if(Auth::check()){
                $videoPosts[$key]->allLike = likeVideo::GetCurrentLike($value->id,true);
            }
        }

        if($request->ajax()){

            return [
                'videoPosts' => view('postVideos.ajax-posting-part')->with('videoPosts',$videoPosts)->with('n',$n)->render(),
                'next_page' => $videoPosts->nextPageUrl()
            ];

        }


        return view('postVideos.show')->with('defs', $defs)->with('display',$display)
            ->with('spelling',$spelling)->with('type',$type)->with('example',$example)
            ->with('selectOption',$selectOption)->with('q',$q)->with('n',$n)->with('videoPosts',$videoPosts);
    }

    public function delete(Request $request){

        $id = $request->input('getId');

        $post = DB::table('videos')->where('id',$id);
        $post->delete();

        return response($id);
    }

    public function like(Request $request){
        $postId = $request->input('getId');

        $userId = $request->input('currentUserId');

        //TODO $data = query table like where imgPost_id = $postId and user_id = $userId;
        //TODO if(!empty(data)) else

        $checks = DB::table('like_videos')->where('video_id',$postId)->where('user_id',$userId)->get();


        if($checks->isNotEmpty()){

            DB::table('like_videos')->where('video_id',$postId)->where('user_id',$userId)->update(['like'=>1]);

        }else{

            $like = new likeVideo;

            $like->video_id = $postId;
            $like->user_id = $userId;
            $like->like= 1;

            $like->save();

            return response($like);
        }

    }

    public function reverseLike(Request $request){

        $postId = $request->input('getId');

        $userId = $request->input('currentUserId');

        $like = DB::table('like_videos')->where('video_id',$postId)->where('user_id',$userId)->update(['like'=>0]);

        return response($like);
    }

    public function getLike(Request $request){

        $postId = $request->input('getId');

        $sumLike = DB::table('like_videos')->where('video_id',$postId)->sum('like');

        return response($sumLike);
    }

    public function comment($postId){

        $defs=['','','','',''];
        $display='';
        $spelling='';
        $type='';
        $example=['','','','',''];
        $selectOption='E';
        $q ='';
        $n = 0;

        $videoPosts = DB::table('videos')->where('id',$postId)->get();

        foreach ($videoPosts as $videoPost){
            $videoPost->sumComment = commentVid::GetById($videoPost->id,true);
            $videoPost->user = User::GetById($videoPost->user_id,true);
            $videoPost->sumLike = likeVideo::GetById($videoPost->id,true);

            if(Auth::check()){
                $videoPost->allLike = likeVideo::GetCurrentLike($videoPost->id,true);
            }
        }

        return view('postVideos.comment-pages')->with('defs', $defs)->with('display',$display)
            ->with('spelling',$spelling)->with('type',$type)->with('example',$example)
            ->with('selectOption',$selectOption)->with('q',$q)->with('n',$n)->with('videoPost',$videoPost);
    }

    public function countComment(Request $request){

        $id = $request->input('id');

        $commentCount = DB::table('comment_vids')->where('video_id',$id)->count();

        return response($commentCount);

    }

    public function getComment(Request $request){

        $postId = $request->input('postId');

        $comments = DB::table('comment_vids')->where('video_id', $postId)->get();

        foreach ($comments as $comment){
            $comment->user = User::GetById($comment->user_id,true);
        }

        return response($comments);
    }

    public function inputComment(Request $request){

        $comment = new commentVid;
        $comment->user_id = $request->input('userId');
        $comment->video_id = $request->input('postId');
        $comment->comment = $request->input('comment');

        $comment->save();

        return response($comment);
    }

    public function update(Request $request){

        $id = $request->input('postId');

        $oldFile = DB::table('videos')->where('id',$id)->value('video');

        $youtubeLink = $request->input('youtube');
        $iframeLink = $request->input('iframe');

        if($youtubeLink !== null){
            $nameToDisplay = $youtubeLink;
        }else if($iframeLink !== null){
            $nameToDisplay = $iframeLink;
        }else{
            $nameToDisplay = $oldFile;
        }

        $edit = Video::find($id);
        $edit->title = $request->input('title');
        $edit->description = $request->input('desc');
        $edit->video = $nameToDisplay;

        $edit->save();

        return response($edit);
    }

    public function restartModal(Request $request){

        $id = $request->input('id');

        $video = DB::table('videos')->where('id', $id)->get();

        return response($video);
    }
}
