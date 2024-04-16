<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use App\Events\MessageSent;
use Illuminate\Http\Request;

class MessageController extends Controller
{

public function store(Request $request)
  {

    $message = Message::create([
      'sender_id' => auth()->id(),
      'receiver_id' => $request->receiver_id,
      'body' => $request->body
    ]);

    // broadcast(new MessageSent(auth()->user(), $message->body))->toOthers();
    broadcast(new MessageSent(auth()->user(), $message->body));

    return ['message' => 'Message created successfully'];
  }

  /**
   * Display the specified resource.
   */
  public function show(User $user)
  {
    $messages = Message::select('body')->whereReceiverId($user->id)->whereSenderId(auth()->id())->pluck('body');
    return $messages;
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(Message $message)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update($request, Message $message)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Message $message)
  {
    //
  }
}
