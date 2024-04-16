<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use Illuminate\Support\Facades\Cache;

class CategoryController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    // $categories = Cache::remember('categories', now()->addMinutes(10), fn () => Category::with(['user', 'posts.comments'])->paginate(40));
    $categories = Category::with(['user', 'posts.comments'])->paginate(40);
    return view('category.index')->with(['categories' => $categories]);
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    //
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(StoreCategoryRequest $request)
  {
    //
  }

  /**
   * Display the specified resource.
   */
  public function show(Category $category)
  {
    return view('category.show')->with([
      'category' => $category->load('posts')
    ]);
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(Category $category)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(UpdateCategoryRequest $request, Category $category)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Category $category)
  {
    //
  }
}
