<?php

namespace App\Services;

use Illuminate\Support\Facades\Request;

class ImageUpload
{
  public function upload(Request $request)
  {
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
}
