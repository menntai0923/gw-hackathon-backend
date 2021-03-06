<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Post;

use App\Category;
use App\KipUser;
use App\Like;
use App\Useful;


class PostsController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function index(Request $request)
    {
        $posts = Post::orderBy($request->type, 'asc')->
        where('category_id',$request->category)->
        offset($request->offset)->
        limit($request->limit)->get();
        // jsonに変換
        $cun=0;
        if(empty($posts[$cun])){
            return response('ステータスコード400', 400);
        }
        else{

            
            while(!empty($posts[$cun])){
                $user = KipUser::find($posts[$cun]->user_id);
                $like = Like::count($posts[$cun]->id);
                $useful = Useful::count($posts[$cun]->id);
                $outlines[]=
                    array(
                        "id" => $posts[$cun]->id,
                        "user" => array("id" => $user->id,
                        "uid" => $user->uid,
                        "name" => $user->name,
                        "image" => $user->image_path,
                        ),
                        "like_users" => $like,
                        "useful_count" => $useful,
                        "category" => $posts[$cun]->category_id,
                        "content" => $posts[$cun]->content,
                        "created_at" => $posts[$cun]->created_at,
                        "update_at" => $posts[$cun]->update_at,
                    );
                    $cun++;
            }
            return $outlines;
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = KipUser::find($request->user_id);
        $post = new Post;
        $post->user_id = $request->user_id;
        $post->content = $request->content;
        $post->category_id = $request->category_id;
        $post->save();
        $like = Like::count($post->id);
        $useful = Useful::count($post->id);
        // jsonに変換
        return json_encode(
            array(
                "id" => $post->id,
                "user" => array("id" => $user->id,
                "uid" => $user->uid,
                "name" => $user->name,
                "image" => $user->image_path,
                ),
                "like_users" => $like,
                "useful_count" => $useful,
                "category" => $post->category_id,
                "content" => $post->content,
                "created_at" => $post->created_at,
                "update_at" => $post->update_at,
            )
        );//
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if($post = Post::find($id)==NULL){
            return response('ステータスコード400', 400);
        }
        else{
        $post = Post::find($id);
        $user = KipUser::find($post->user_id);
        $like = Like::count($post->id);
        $useful = Useful::count($post->id);
        // jsonに変換
        return json_encode(
            array(
                "id" => $post->id,
                "user" => array("id" => $user->id,
                "uid" => $user->uid,
                "name" => $user->name,
                "image" => $user->image_path,
                ),
                "like_users" => $like,
                "useful_count" => $useful,
                "category" => $post->category_id,
                "content" => $post->content,
                "created_at" => $post->created_at,
                "update_at" => $post->update_at,
            )
        );//
    }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $post = Post::find($id);
        $post->user_id = $request->user_id;
        $post->content = $request->content;
        $post->category = $request->category;
        $like = Like::count($post->id);
        $useful = Useful::count($post->id);
        // jsonに変換
        return json_encode(
            array(
                "id" => $post->id,
                "user" => array("id" => $user->id,
                "uid" => $user->uid,
                "name" => $user->name,
                "image" => $user->image_path,
                ),
                "like_users" => $like,
                "useful_count" => $useful,
                "category" => $post->category_id,
                "content" => $post->content,
                "created_at" => $post->created_at,
                "update_at" => $post->update_at,
            )
        );//
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::find($id);
        if($post!=NULL){
            $post->delete();
            return response('ステータスコード200', 200);
        }
        else{
            return response('ステータスコード400', 400);
        }//
    }
}
