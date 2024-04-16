<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SettingController extends Controller
{
  public function update(Request $request, $user_id)
  {
    $data = $request->validate([
      'mention_notifiable' => 'nullable|bool',
      'like_notifiable' => 'nullable|bool',
      'follow_notifiable' => 'nullable|bool',
      'comment_notifiable' => 'nullable|bool',

    ]);

    if (Setting::where(['user_id' => $user_id])->update($data)) {
      return ['message' => 'Settings Updated Successfully!'];
    }

    return ['message' => 'Settings Update Not Successful!'];
  }
}
