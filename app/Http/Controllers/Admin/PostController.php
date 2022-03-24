<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Post;
use App\Category;
use App\Tag;
use Illuminate\Support\Str;

class PostController extends Controller
{

    protected $validation = [
        'title' => 'required|max:50',
        'content' => 'required',
        'category_id' => 'nullable|exists:categories,id',
        'tags' => 'nullable|exists:tags,id'
    ];

    protected function slug($title = "", $id = "")
    {
        $tmp = Str::slug($title);
        $count = 1;
        while (Post::where('slug', $tmp)->where('id', '!=', $id)->first()) {
            $tmp = Str::slug($title) . "-" . $count;
            $count++;
        }
        return $tmp;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::all();
        return view('admin.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    { {
            $categories = Category::all();
            $tags = Tag::all();
            return view('admin.posts.create', compact(['categories', 'tags']));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate($this->validation);

        $data = $request->all();

        $data['slug'] = $this->slug($data["title"]);

        $newPost = new Post();

        $newPost->fill($data);
        $newPost->save();
        $newPost->tags()->sync(isset($data['tags']) ? $data['tags'] : []);
        return redirect()->route('admin.posts.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return view('admin.posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        $categories = Category::all();
        $tags = Tag::all();
        return view('admin.posts.edit', compact(['post', 'categories', 'tags']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $request->validate($this->validation);

        $data = $request->all();

        $data["slug"] = ($post->title == $data['title']) ? $post->slug : $this->slug($data["title"], $post->id);

        $post->update($data);

        $post->tags()->sync(isset($data['tags']) ? $data['tags'] : []);

        return redirect()->route('admin.posts.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return redirect()->route('admin.posts.index');
    }
}
