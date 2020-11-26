<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Illuminate\Http\Response;

class MessageController extends Controller
{

    public function index()
    {
        $messages = Message::where('sender_id', Auth::id())->get();
        if ($messages) {
            return (new Response($messages, 200))->header('Content-Type', 'application/json');
        } else {
            return (new Response(404))->header('Content-Type', 'application/json');
        }
    }

    public function store(Request $request)
    {
        $message = new Message;

        $this->validate($request, [
            'message' => 'required|max:255',
            'destinataire' => 'required | max:255'
        ]);

        $destinataire = User::where('username', $request->destinataire)->first();
        if ($destinataire) {
            $message->message = $request->message;
            $message->receiver_id = $destinataire->id;
            $message->sender_id = Auth::id();
            $message->created_at = Carbon::now();
            $message->save();

            return (new Response($message, 200))->header('Content-Type', 'application/json');
        } else {
            return (new Response(404))->header('Content-Type', 'application/json');
        }
    }

    public function show($id)
    {
        $message = Message::find($id);
        $receiver = User::find($message->receiver_id);
        if ($message) {
            return (new Response([$message, $receiver], 200))->header('Content-Type', 'application/json');
        } else {
            return (new Response(422))->header('Content-Type', 'application/json');
        }
    }

    public function update(Request $request, $id)
    {
        $message = Message::find($id);

        $this->validate($request, [
            'message' => 'required | max:255',
        ]);

        if ($message) {
            $message->message = $request->message;
            $message->updated_at = Carbon::now();
            $message->save();

            $receiver = User::find($message->receiver_id);
            return (new Response([$message, $receiver], 200))->header('Content-Type', 'application/json');
        } else {
            return (new Response(422))->header('Content-Type', 'application/json');
        }
    }

    public function destroy($id)
    {

        Message::destroy($id);
        if (Message::destroy($id)) {
            return (new Response(200))->header('Content-Type', 'application/json');
        } else {
            return (new Response(422))->header('Content-Type', 'application/json');
        }
    }
}
