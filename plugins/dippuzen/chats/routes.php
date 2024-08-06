<?php

use Illuminate\Http\Request;
use Dippuzen\Chats\Models\Chat;
use Response;
use File;

Route::options('{any}', function () {
    return response()->json([], 204)
        ->header('Access-Control-Allow-Origin', '*')
        ->header('Access-Control-Allow-Methods', 'POST, GET, OPTIONS, PUT, DELETE')
        ->header('Access-Control-Allow-Headers', 'Content-Type, Authorization');
})->where('any', '.*');

Route::get('/', function () {
    return Redirect::to('/backend');
});

Route::get('api/getAllChats/{id}', function ($id) {
    $chats = Chat::where('uid', $id)->get();
    
    $chatswithoutmessages = $chats->map(function ($chat) {
        return [
            'id' => $chat->conversation_id,
            'title' => $chat->title,
        ];
    });

    return response()->json($chatswithoutmessages)
        ->header('Content-Type', 'application/json')
        ->header('Access-Control-Allow-Origin', '*');
});


Route::get('api/getMessages/{id}/{cid}', function ($id,$cid) {
    $chat = Chat::where('uid', $id)->where('conversation_id', $cid)->first();
    if ($chat) {
        $data = [
            'uid' => $id,
            'conversation_id' => $cid,
            'messages' => $chat->messages,
            'title' => $chat->title,
            'topic' => $chat->topic
        ];
        
        return response()->json($data)
            ->header('Content-Type', 'application/json')
            ->header('Access-Control-Allow-Origin', '*');
    } else {
        return response()->json(['error' => 'Bot not found'], 404)
            ->header('Content-Type', 'application/json')
            ->header('Access-Control-Allow-Origin', '*');
    }
});

Route::post('api/addMessages/{cid}', function ($cid, Request $request) {
    // Find the chat by conversation_id
    $chat = Chat::where('conversation_id', $cid)->first();

    if ($chat) {
        // Validate the incoming request
        $validatedData = $request->validate([
            'messages' => 'required|array',
            'messages.*.role' => 'required|string',
            'messages.*.content' => 'required|string',
        ]);

        // Replace the chat's messages field with the new data
        $chat->messages = $validatedData['messages'];
        $chat->save();

        // Respond with success
        return response()->json(['success' => 'Messages replaced successfully'])
            ->header('Content-Type', 'application/json')
            ->header('Access-Control-Allow-Origin', '*');
    } else {
        return response()->json(['error' => 'Chat not found'], 404)
            ->header('Content-Type', 'application/json')
            ->header('Access-Control-Allow-Origin', '*');
    }
});


Route::post('api/createChat', function (Request $request) {
    // Validate the incoming request data
    $validatedData = $request->validate([
        'title' => 'required|string|max:255',
        'topic' => 'required|string|max:255',
        'messages' => 'required', // Assuming messages is validated correctly
        'uid' => 'required|string|max:255',
    ]);

    // Generate a unique conversation ID
    $conversation_id = 'conv' . Str::random(4);

    // Create a new Chat instance and populate it with data
    $chat = new Chat();
    $chat->title = $validatedData['title'];
    $chat->topic = $validatedData['topic'];
    $chat->messages = $validatedData['messages'];
    $chat->uid = $validatedData['uid'];
    $chat->conversation_id = $conversation_id;
    $chat->save();
    
    // Prepare the response data
    $data = [
        'id' => $conversation_id,
    ];

    // Return the response with CORS headers
    return response()->json($data)
        ->header('Content-Type', 'application/json')
        ->header('Access-Control-Allow-Origin', '*')
        ->header('Access-Control-Allow-Methods', 'POST')
        ->header('Access-Control-Allow-Headers', 'Content-Type, Authorization');
});

Route::delete('api/deleteAllChats/{uid}', function ($uid) {
    // Find all chats by the given uid
    $chats = Chat::where('uid', $uid)->get();

    if ($chats->isEmpty()) {
        return response()->json(['error' => 'No chats found for the given UID'], 404)
            ->header('Content-Type', 'application/json')
            ->header('Access-Control-Allow-Origin', '*');
    }

    // Delete all found chats
    foreach ($chats as $chat) {
        $chat->delete();
    }

    return response()->json(['success' => 'All chats deleted successfully'])
        ->header('Content-Type', 'application/json')
        ->header('Access-Control-Allow-Origin', '*');
});

