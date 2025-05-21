<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ChatbotResponse;

class ChatbotResponseApiController extends Controller
{
     //RESPONSES
    // GET response by intent_id
    public function getResponse($intent_id)
    {
        $response = ChatbotResponse::where('intent_id', $intent_id)->first();
        return response()->json($response);
    }
    //Post Response
    public function createResponse(Request $request)
{
    $data = $request->validate([
        'intent_id' => 'required|exists:chatbot_intents,id',
        'response_text' => 'required|string',
        'value' => 'nullable|string',
        'params' => 'nullable|array',
    ]);
    $data['params'] = json_encode($data['params']);
    $response = ChatbotResponse::create($data);
    return response()->json($response, 201);
}
    // PUT response
    public function updateResponse(Request $request, $id)
{
    $response = ChatbotResponse::find($id);
    if (!$response) return response()->json(['message' => 'Response not found'], 404);

    $data = $request->validate([
        'intent_id' => 'required|exists:chatbot_intents,id',
        'response_text' => 'required|string',
        'value' => 'nullable|string',
        'params' => 'nullable|array',
    ]);
    $data['params'] = json_encode($data['params']);
    $response->update($data);
    return response()->json($response);
}
    // DELETE response
    public function deleteResponse($id)
{
    $response = ChatbotResponse::find($id);
    if (!$response) return response()->json(['message' => 'Response not found'], 404);
    $response->delete();
    return response()->json(['message' => 'Response deleted']);
}

}