<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NotificationController extends Controller
{
    public function destroy($id = null) {
      if (!$id) {
        auth()->user()->notifications()->delete();
        return redirect()->back();
      }

      DB::table('notifications')->whereId($id)->delete();
      return redirect()->back();
    }
}
