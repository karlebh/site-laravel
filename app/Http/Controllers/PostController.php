<?php

namespace App\Http\Controllers;

use App\Events\TriggerMentionEvent;
use App\Models\Image;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
use App\Notifications\UserMentioned;
use App\Services\ImageUpload;
use Illuminate\Support\Facades\Notification;


class PostController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth')->except(['index', 'show']);
  }

  public function index()
  {
    return view('dashboard');
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    return view('post.create');
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    $data = $request->validate([
      'title' => 'required|min:4|max:300|string',
      'body' => 'required|min:3',
      'category_id' => 'required|integer',
    ]);

    $slug = str()->slug($data['title']) .  rand(1000, 5000);

    $post = Post::firstOrCreate(
      ['title' => $data['title']],
      array_merge(
        $data,
        [
          'user_id' => auth()->id(),
          'slug' => $slug,
        ]
      )
    );

    if ($request->has('images')) {

      $images = $request->validate([
        'images.*' => 'nullable|image|mimes:jpg,jpeg,png,gif',
      ]);

      foreach ($images['images'] as $image) {

        $imageName = time() . '.' . $image->extension();
        $image->storeAs('uploads', $imageName, 'public');

        $post->images()->create([
          'src' => $imageName,
          'user_id' => auth()->id(),
          'imageable_id' => $post->id,
          'imageable_type' => Post::class,
        ]);
      }
    }

    $url = route('post.show', $post);

    event(new TriggerMentionEvent($post, $url));

    $request->session()->flash('message', 'Post created successfully');

    return redirect()->route('post.show', $post);
  }

  /**
   * Display the specified resource.
   */
  public function show(Post $post)
  {
    $like = \App\Models\Like::where([
      "user_id" => auth()->id(),
      "likeable_id" => $post->id,
      "likeable_type" => $post::class,
    ])->exists();

    return view('post.show')->with(['post' => $post->load('comments'), 'like' => $like]);
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(Post $post)
  {
    $this->authorize('edit', $post);

    return view('post.edit')->with(['post' => $post]);
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, Post $post)
  {
    $this->authorize('update', $post);

    $data = $request->validate([
      'title' => ['required', 'min:4', 'max:300', 'string'],
      'body' => ['required', 'min:3'],
      'category_id' => ['required']
    ]);

    if ($post->title !== $request->title) {
      $data['slug'] = str()->slug($request->title);
    }

    $post->update($data);

    if ($request->images) {

      $images = $request->validate([
        'images.*' => 'nullable|image|mimes:jpg,jpeg,png,gif',
      ]);

      foreach ($images['images'] as $image) {

        $imageName = time() . '.' . $image->extension();
        $image->storeAs('uploads', $imageName, 'public');

        $post->images()->create([
          'src' => $imageName,
          'user_id' => auth()->id(),
          'imageable_id' => $post->id,
          'imageable_type' => Post::class,
        ]);
      }
    }
    $url = route('post.show', $post);

    event(new TriggerMentionEvent($post, $url));

    $request->session()->flash('message', 'Post updated successfully');

    return redirect()->route('post.show', $post);
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Post $post)
  {
    $this->authorize('destroy', $post);

    $post->delete();

    return redirect()->route('post.index');
  }
}
