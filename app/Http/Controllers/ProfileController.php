<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\User;

class ProfileController extends Controller
{
  public function show($name)
  {
    return view('profile.show', ['name' => $name]);
  }
  /**
   * Display the user's profile form.
   */
  public function edit(Request $request): View
  {
    return view('profile.edit', [
      'user' => $request->user()->load('setting'),
    ]);
  }

  public function profileImage(Request $request)
  {
    $user = $request->user();

    abort_if($user->id !== Auth::id(), 403);

    $data = $request->validate(['profile_image' => ['required', 'image', 'mimes:jpg,jpeg,png,gif']]);

    $imageName = time() . '.' . $data['profile_image']->extension();
    $data['profile_image']->storeAs('uploads', $imageName, 'public');

    $user->image()->updateOrCreate(
      [
        'imageable_id' => $user->id,
        'imageable_type' => $user::class,
      ],
      [
        'src' => $imageName,
        'user_id' => auth()->id(),
        'imageable_id' => $user->id,
        'imageable_type' => $user::class,
      ]
    );

    return redirect()->back();
  }

  public function removeProfilepicture(User $user)
  {
    abort_if($user->id !== Auth::id(), 403);
    $user->image->delete();
    return 'success';
  }

  /**
   * Update the user's profile information.
   */
  public function update(ProfileUpdateRequest $request)
  {
    abort_if($request->user()->id !== Auth::id(), 403);
    //There should be a space for Admin in this in the future

    $request->user()->fill($request->validated());

    if ($request->user()->isDirty('email')) {
      $request->user()->email_verified_at = null;
    }

    $request->user()->save();

    // return Redirect::route('profile.edit')->with('status', 'profile-updated');
    return ['message' => "profile updated successfully!"];
  }

  /**
   * Delete the user's account.
   */
  public function destroy(Request $request): RedirectResponse
  {
    abort_if($request()->user->id !== Auth::id(), 403);

    $request->validateWithBag('userDeletion', [
      'password' => ['required', 'current_password'],
    ]);

    $user = $request->user();

    Auth::logout();

    $user->delete();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return Redirect::to('/');
  }
}
