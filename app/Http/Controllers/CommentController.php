<?php

namespace App\Http\Controllers;

use App\Events\TriggerMentionEvent;
use App\Models\Comment;
use App\Models\Post;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use App\Models\Image;
use App\Models\User;
use App\Notifications\CommentedOnPost;
use App\Notifications\UserMentioned;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class CommentController extends Controller
{

  public function store(Request $request)
  {

    $data = $request->validate([
      'body' => ['required',],
      'post_id' => ['required', 'integer'],
      'parent_id' => ['nullable', 'integer']
    ]);

    $comment = Comment::firstOrCreate(
      array_merge($data, [
        'user_id' => auth()->id(),
      ])
    );

    if ($request->has('images')) {

      $images = $request->validate([
        'images.*' => 'nullable|image|mimes:jpg,jpeg,png,gif',
      ]);

      foreach ($images['images'] as $image) {
        $imageName = time() . '.' . $image->extension();
        $image->storeAs('uploads', $imageName, 'public');

        $comment->images()->create([
          'src' => $imageName,
          'user_id' => auth()->id(),
          'imageable_id' => $comment->id,
          'imageable_type' => Post::class,
        ]);
      }
    }

    $url = route('post.show', $request->post_slug) . "#comment-#$comment->id";

    // event(new TriggerMentionEvent($comment, $url));

    $comment = $comment->load('post.user.setting');

    if (
      $this->userCanHaveCommentNotifications($comment)
      && $comment->post->user_id !== auth()->id()
    ) {
      Notification::send($comment->post->user, new CommentedOnPost(
        postOwner: $comment->post->user,
        commentOwner: $comment->user,
        url: $url,
      ));
    }

    $url = route('post.show', $comment->post) . "#comment-#$comment->id";

    return redirect()->to($url);
  }

  public function edit(Comment $comment)
  {
    abort_if($comment->user->id !== auth()->id(), 403);

    return view('comment.edit')->with(['comment' => $comment]);
  }

  public function update(Comment $comment, Request $request)
  {
    abort_if($comment->user->id !== auth()->id(), 403);

    $data = $request->validate([
      'body' => ['required',],
    ]);

    if (
      $request->has('images')
      && $comment->images()->count() === $comment->max_image
    ) {
      $request->session()->flash('message', 'maximum number of image per picture reached');
      return redirect()->back();
    }

    $comment->update($data);

    $imageArr = [];

    if ($request->has('images')) {
      $images = $request->validate([
        'images.*' => ['nullable', 'image', 'mimes:jpg,jpeg,png,gif']
      ]);

      foreach ($images['images'] as $image) {
        $imageName = time() . '.' . $image->extension();
        $image->storeAs('comments', $imageName, 'public');

        array_push($imageArr, [
          'src' => $imageName,
          'user_id' => auth()->id(),
          'imageable_id' => $comment->id,
          'imageable_type' => Comment::class,
        ]);
      }
    }

    Image::insert($imageArr);

    $request->session()->flash('message', 'Comment Updated Successfully');

    $url = route('post.show', $comment->post) . "#comment-#$comment->id";

    return redirect()->to($url);
  }

  private function userCanHaveCommentNotifications($model)
  {
    return $model->post->user->setting->comment_notifiable;
  }

  public function destroy(Comment $comment)
  {
    $this->authorize('delete', $comment);
    $comment->delete();

    $url = route('post.show', $comment->post);
    return redirect()->to($url);
  }
}
