<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ChatbotIntent;
use Illuminate\Http\Request;

class ChatbotIntentApiController extends Controller
{

     /**
     * Get Intent
     *
     * @param  mixed $request
     * @return void
     */

    // GET all intents
    public function getIntents()
    {
        return response()->json(ChatbotIntent::all());
    }

     /**
     * Post Intent
     *
     * @param  mixed $request
     * @return void
     */
    //Post intents
    public function storeIntent(Request $request)
{
    $data = $request->validate([
        'id'=> 'nullable|integer',
        'name' => 'required|string|max:255',
        'description' => 'nullable|string|max:255',
    ]);
    $intent = ChatbotIntent::create($data);
    return response()->json($intent, 201);
}



     /**
     * Put Intent
     *
     * @param  mixed $request
     * @return void
     */
    // PUT intents
    public function updateIntent(Request $request, $id)
{
    $intent = ChatbotIntent::find($id);
    if (!$intent) return response()->json(['message' => 'Intent not found'], 404);

    $data = $request->validate([
        'name' => 'required|string|max:255',
    ]);
    $intent->update($data);
    return response()->json($intent);
}


        /**
        * Delete Intent
        *
        * @param  mixed $request
        * @return void
        */
    // DELETE intents
    public function deleteIntent($id)
{
    $intent = ChatbotIntent::find($id);
    if (!$intent) return response()->json(['message' => 'Intent not found'], 404);
    $intent->delete();
    return response()->json(['message' => 'Intent deleted']);
}

}
