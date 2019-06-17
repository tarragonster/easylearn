<?php

namespace App\Http\Controllers;

use App\Providers\CacheLog;
use App\Providers\TranslateFree;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Royalmar\HtmlDomParser\HtmlDomParser;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Search;
use App\imagePost;
use App\Like;
use App\Comment;
use Carbon\Carbon;
use Symfony\Component\Routing\Tests\Fixtures\AnnotationFixtures\DefaultValueController;

class PostImageController extends Controller
{
    public function store(Request $request){

        $n = 0;

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
            $nameToDisplay ='/storage/update_images/noimage.jpg';
        }

        if($request->ajax()){

            if($request->input('title') !== null){

                $imagePost = new imagePost;
                $imagePost->title =$request->input('title');
                $imagePost->description =$request->input('description');
                $imagePost->update_image=$nameToDisplay;
                $imagePost->user_id = Auth::user()->id;


                $imagePost->save();
            }

            $imagePosts = DB::table('image_posts')->orderBy('created_at','desc')->paginate(2);


            foreach ($imagePosts as $key=>$value){
                $imagePosts[$key]->sumComment = Comment::GetById($value->id,true);
                $imagePosts[$key]->user = User::GetById($value->user_id,true);
                $imagePosts[$key]->sumLike = Like::GetById($value->id,true);

                if(Auth::check()){
                    $imagePosts[$key]->allLike = Like::GetCurrentLike($value->id,true);
                }
            }

            return [
                'imagePosts' => view('postImages.ajax-posting-part')->with('imagePosts',$imagePosts)->with('n',$n)->render(),
                'next_page' => $imagePosts->nextPageUrl()
            ];

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

        $imagePosts = DB::table('image_posts')->orderBy('created_at','desc')->paginate(2);

        foreach ($imagePosts as $key=>$value){

            $imagePosts[$key]->sumComment = Comment::GetById($value->id,true);
            $imagePosts[$key]->user = User::GetById($value->user_id,true);
            $imagePosts[$key]->sumLike = Like::GetById($value->id,true);

            if(Auth::check()){
                $imagePosts[$key]->allLike = Like::GetCurrentLike($value->id,true);
            }
        }

        if($request->ajax()){

            return [
                'imagePosts' => view('postImages.ajax-posting-part')->with('imagePosts',$imagePosts)->with('n',$n)->render(),
                'next_page' => $imagePosts->nextPageUrl()
            ];

        }

        return view('postImages.show')->with('defs', $defs)->with('display',$display)
            ->with('spelling',$spelling)->with('type',$type)->with('example',$example)
            ->with('selectOption',$selectOption)->with('q',$q)->with('n',$n)->with('imagePosts',$imagePosts);
    }

    public function delete(Request $request){

        $id = $request->input('getId');

        $post = DB::table('image_posts')->where('id',$id);
        $post->delete();

        return response($id);
    }

    public function like(Request $request){
        $postId = $request->input('getId');

        $userId = $request->input('currentUserId');

        //TODO $data = query table like where imgPost_id = $postId and user_id = $userId;
        //TODO if(!empty(data)) else

        $checks = DB::table('likes')->where('imagePost_id',$postId)->where('user_id',$userId)->get();


        if($checks->isNotEmpty()){

            DB::table('likes')->where('imagePost_id',$postId)->where('user_id',$userId)->update(['like'=>1]);

        }else{

            $like = new Like;

            $like->imagePost_id = $postId;
            $like->user_id = $userId;
            $like->like= 1;

            $like->save();

            return response($like);
        }

    }

    public function reverseLike(Request $request){

        $postId = $request->input('getId');

        $userId = $request->input('currentUserId');

        $like = DB::table('likes')->where('imagePost_id',$postId)->where('user_id',$userId)->update(['like'=>0]);

        return response($like);
    }

    public function getLike(Request $request){

        $postId = $request->input('getId');

        $sumLike = DB::table('likes')->where('imagePost_id',$postId)->sum('like');

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

        $imagePosts = DB::table('image_posts')->where('id',$postId)->get();

        foreach ($imagePosts as $imagePost){

            $imagePost->sumComment = Comment::GetById($imagePost->id,true);
            $imagePost->user = User::GetById($imagePost->user_id,true);
            $imagePost->sumLike = Like::GetById($imagePost->id,true);

            if(Auth::check()){
                $imagePost->allLike = Like::GetCurrentLike($imagePost->id,true);
            }
        }

        return view('postImages.comment-pages')->with('defs', $defs)->with('display',$display)
            ->with('spelling',$spelling)->with('type',$type)->with('example',$example)
            ->with('selectOption',$selectOption)->with('q',$q)->with('n',$n)->with('imagePost',$imagePost);
    }

    public function inputComment(Request $request){

        $comment = new Comment;
        $comment->user_id = $request->input('userId');
        $comment->imagePost_id = $request->input('postId');
        $comment->comment = $request->input('comment');

        $comment->save();

        return response($comment);
    }

    public function getComment(Request $request){

        $postId = $request->input('postId');

        $comments = DB::table('comments')->where('imagePost_id', $postId)->get();

        foreach ($comments as $comment){
            $comment->user = User::GetById($comment->user_id,true);
        }

        return response($comments);
    }

    public function countComment(Request $request){

        $id = $request->input('id');

        $commentCount = DB::table('comments')->where('imagePost_id',$id)->count();

        return response($commentCount);

    }

    public function update(Request $request){

        $id = $request->input('postId');

        $oldFile = DB::table('image_posts')->where('id',$id)->value('update_image');

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

        $edit = imagePost::find($id);
        $edit->title = $request->input('title');
        $edit->description = $request->input('description');
        $edit->update_image = $nameToDisplay;

        $edit->save();

        return response($edit);
    }

    public function restartModal(Request $request){

        $id = $request->input('id');

        $post = DB::table('image_posts')->where('id', $id)->get();

        return response($post);
    }

    public function search(Request $request){
        $n = 0;

        $search = $request->input('q');

        $imagePosts = DB::table('image_posts')->where('title','like','%'.$search.'%')->paginate(2);

        foreach ($imagePosts as $key=>$value){

            $imagePosts[$key]->sumComment = Comment::GetById($value->id,true);
            $imagePosts[$key]->user = User::GetById($value->user_id,true);
            $imagePosts[$key]->sumLike = Like::GetById($value->id,true);

            if(Auth::check()){
                $imagePosts[$key]->allLike = Like::GetCurrentLike($value->id,true);
            }
        }

        if($request->ajax()){

            $pSearch = $request->input('searchInfo');

            $pImagePosts = DB::table('image_posts')->where('title','like','%'.$pSearch.'%')->paginate(2);

            foreach ($pImagePosts as $key=>$value){

                $pImagePosts[$key]->sumComment = Comment::GetById($value->id,true);
                $pImagePosts[$key]->user = User::GetById($value->user_id,true);
                $pImagePosts[$key]->sumLike = Like::GetById($value->id,true);

                if(Auth::check()){
                    $pImagePosts[$key]->allLike = Like::GetCurrentLike($value->id,true);
                }
            }

            return [
                'imagePosts' => view('postImages.ajax-posting-part')->with('imagePosts',$pImagePosts)->with('n',$n)->render(),
                'next_page' => $pImagePosts->appends($pSearch)->nextPageUrl()
            ];
        }

        return view('postImages.show')->with('imagePosts',$imagePosts)->with('n',$n)->with('q',$search);

    }
}
