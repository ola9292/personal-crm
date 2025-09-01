<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with('category')->get();

        return Inertia::render('Post/Index', [
            'posts' => $posts
        ]);
    }
    public function show(Request $request, $id)
    {

        $post = Post::findOrFail($id);
        $post->image_url = $post->image_url ? asset('storage/' . $post->image_url) : null;
        return Inertia::render('Post/Single', [
            'post' => $post,

        ]);
    }
    public function create()
    {
        $categories = Category::all();
        return Inertia::render('Post/Create',[
            'categories' => $categories,
        ]);
    }
    public function store(Request $request)
    {

        //dd($request->input('category_id'));
        $data = $request->validate([
          'title' => ['required', 'max:255'],
          'content' => ['required'],
          'image_url' => ['nullable', 'file', 'image', 'max:2048'],
        ]);

        if ($request->hasFile('img_url')) {
                $data['image_url'] = $request->file('img_url')->store('posts', 'public');
            }

        $data['user_id'] = Auth::user()->id;
        $data['category_id'] = $request->input('category_id') != null ? $request->input('category_id') : 0;

        Post::create($data);

        return to_route('post.index');

    }

    public function update(Request $request)
    {

        dd($request->input('category_id'));
        $data = $request->validate([
          'title' => ['required', 'max:255'],
          'content' => ['required'],
          'image_url' => ['nullable', 'file', 'image', 'max:2048'],
        ]);

        if ($request->hasFile('img_url')) {
                $data['image_url'] = $request->file('img_url')->store('posts', 'public');
            }

        $data['user_id'] = Auth::user()->id;
        $data['category_id'] = $request->input('category_id') != null ? $request->input('category_id') : 0;

        Post::create($data);

        return to_route('post.index');

    }
}
