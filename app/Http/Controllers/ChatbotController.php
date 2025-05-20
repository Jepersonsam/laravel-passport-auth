<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ChatbotIntent;
use App\Models\ChatbotQuestion;
use App\Models\ChatbotResponse;

class ChatbotController extends Controller
{
    //INTENTS
    // GET all intents
    public function getIntents()
    {
        return response()->json(ChatbotIntent::all());
    }
    //Post intents
    public function createIntent(Request $request)
{
    $data = $request->validate([
        'name' => 'required|string|max:255',
    ]);
    $intent = ChatbotIntent::create($data);
    return response()->json($intent, 201);
}
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
    // DELETE intents
    public function deleteIntent($id)
{
    $intent = ChatbotIntent::find($id);
    if (!$intent) return response()->json(['message' => 'Intent not found'], 404);
    $intent->delete();
    return response()->json(['message' => 'Intent deleted']);
}

    //QUESTIONS
    // GET questions by intent_id
    public function getQuestions($intent_id)
    {
        $questions = ChatbotQuestion::where('intent_id', $intent_id)->orderBy('order')->get();
        return response()->json($questions);
    }
    //Post Question
    public function createQuestion(Request $request)
{
    $data = $request->validate([
        'intent_id' => 'required|exists:chatbot_intents,id',
        'question_text' => 'required|string',
        'input_key' => 'required|string',
        'input_type' => 'nullable|string',
        'options' => 'nullable|array',
        'is_required' => 'boolean',
        'order' => 'required|integer',
    ]);
    $question = ChatbotQuestion::create($data);
    return response()->json($question, 201);
}
    // PUT questions
    public function updateQuestions(Request $request, $id)
{
    $question = ChatbotQuestion::find($id);
    if (!$question) return response()->json(['message' => 'Question not found'], 404);

    $data = $request->validate([
        'intent_id' => 'required|exists:chatbot_intents,id',
        'question_text' => 'required|string',
        'info' => 'nullable|string',
        'input_key' => 'required|string',
        'input_type' => 'nullable|string',
        'options' => 'nullable|array',
        'is_required' => 'boolean',
        'order' => 'required|integer',
    ]);
    $question->update($data);
    return response()->json($question);
}


    // DELETE questions
    public function deleteQuestion($id)
{
    $question = ChatbotQuestion::find($id);
    if (!$question) return response()->json(['message' => 'Question not found'], 404);
    $question->delete();
    return response()->json(['message' => 'Question deleted']);
}

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



   public function storeQuestionsBulk(Request $request)
{
    $validated = $request->validate([
        '*.intent_id' => 'required|integer|exists:chatbot_intents,id',
        '*.question_text' => 'required|string',
        '*.info' => 'nullable|string',
        '*.input_key' => 'required|string', 
        '*.input_type' => 'nullable|string',
        '*.options' => 'nullable|array',
        '*.is_required' => 'nullable|boolean',
        '*.order' => 'required|integer',
    ]);

    foreach ($validated as $questionData) {
        ChatbotQuestion::create($questionData);
    }

    return response()->json(['message' => 'Questions inserted successfully'], 201);
}

}