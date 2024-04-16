<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;

class ImageController extends Controller
{
  public function destroy(Image $image)
  {
    if (
      $image->delete()
    ) {
      return "Image deleted succesfully";
    }

    return " could not delete image";
  }
}
