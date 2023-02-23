<?php

namespace App\Http\Controllers;

use App\Helpers\RandomHelpers;
use App\Http\Resources\PostDetailResource;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::with(['writer:id,username', 'comments:id,post_id,user_id,comments_content', 'comments.commentator:id,username'])->get();
        return PostDetailResource::collection($posts);
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
        // return $request->file;
        $request->validate([
            'title' => 'required|max:255',
            'news_content' => 'required',
        ]);

        $newname = null;
        if ($request->file) {
            // upload file
            $fileName = RandomHelpers::generateRandomString();
            // dd($fileName);
            $extension = $request->file->extension();
            $newname = $fileName . '.' . $extension;
            Storage::putFileAs('image', $request->file, $newname);
        }

        // $request['author'] = Auth::user()->id;
        $post = Post::create([
            'title' => $request->title,
            'news_content' => $request->news_content,
            'author' => Auth::user()->id,
            'image' => $newname,
        ]);
        return new PostDetailResource($post->loadMissing('writer:id,username'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    // public function show(Post $post)
    // {
    //     // $post = Post::findOrFail($post);
    //     return response()->json(['data' => $post,]);
    // }

    public function show($id)
    {
        $post = Post::with(['writer:id,username', 'comments:id,post_id,user_id,comments_content'])->findOrFail($id);
        return new PostDetailResource($post);
    }

    // public function show2($id)
    // {
    //     $post = Post::findOrFail($id);
    //     return new PostDetailResource($post);
    // }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|max:255',
            'news_content' => 'required',
        ]);

        $post = Post::findOrFail($id);
        $oldPhoto = $post->image;
        $file_path = 'image/' . $oldPhoto;
        // dd($file_path);

        $newname = null;
        if ($request->file) {
            // dd('image baru');
            // upload file
            $fileName = RandomHelpers::generateRandomString();
            $extension = $request->file->extension();
            $newname = $fileName . '.' . $extension;
            Storage::putFileAs('image', $request->file, $newname);
            $post['image'] = $newname;

            if (isset($oldPhoto) || $oldPhoto != '') {
                if (Storage::exists($file_path)) {
                    Storage::delete($file_path);
                }
            }
            // if ($oldPhoto == null || $oldPhoto == '') {
            //     dd('image gk ada');
            // } else {
            //     dd('image lama');
            // }
        }
        // else {
        //     // dd('image lama');
        // }

        $post->update($request->only(['title', 'news_content', 'image']));

        return new PostDetailResource($post->loadMissing('writer:id,username'));
        // return response()->json('ini method update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();

        return new PostDetailResource($post->loadMissing('writer:id,username'));
    }
}
