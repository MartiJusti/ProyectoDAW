<?php

namespace App\Http\Controllers\Api;

use App\Models\Message;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class MessageApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $messages = Message::all();
        return response()->json($messages, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $sender = Auth::user();

        $message = new Message();
        $message->content = $request->content;
        $message->date_sent = now();
        $message->date_received = now();
        $message->sender_id = $sender->id;
        $message->receiver_id = $request->receiver_id;
        $message->save();

        return response()->json($message, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Message $message)
    {
        return response()->json($message, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Message $message)
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


    //Este método devuelve todo el intercambio de mensajes entre el usuario autenticado y otro proporcionado
    public function getMessagesWithUser($otherUserId)
    {
        $authUserId = Auth::id();

        $messages = Message::where(function ($query) use ($authUserId, $otherUserId) {
            $query->where('sender_id', $authUserId)
                ->orWhere('receiver_id', $authUserId);
        })->where(function ($query) use ($otherUserId) {
            $query->where('sender_id', $otherUserId)
                ->orWhere('receiver_id', $otherUserId);
        })->orderBy('date_sent', 'asc')
            ->get();

        if ($messages->isEmpty()) {
            return response()->json(['error' => 'No se encontraron mensajes entre estos usuarios'], 404);
        }

        return response()->json($messages, 200);
    }
}
