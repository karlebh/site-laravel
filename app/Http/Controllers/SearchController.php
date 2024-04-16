<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;

class SearchController extends Controller
{
  public function show()
  {
    return view('search');
  }
  public function search(Request $request)
  {
    $data = "%%$request->p%%";

    $result = [];

    // if (strlen($request->p) >= 2) {
    // $result = Post::where('title', 'like', $data)->orWhere('body', 'like', $data)->get();
    $result = Post::search($request->p)->get();
    // $result = User::search($request->p)->query(fn ($query) => $query->with('posts'))->get();
    // }


    if (count($result)) {
      return [$result, $request->p];
    }

    return "Nothing found";
  }
}
