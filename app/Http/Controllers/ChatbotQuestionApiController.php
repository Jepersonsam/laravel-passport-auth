<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ChatbotQuestion;
use Illuminate\Http\Request;

class ChatbotQuestionApiController extends Controller
{

     /**
     * Get Question
     *
     * @param  mixed $request
     * @return void
     */
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

    public function index()
    {
        return ChatbotQuestion::with('intent')->get();
    }


     /**
     * Post Question
     *
     * @param  mixed $request
     * @return void
     */
    public function storeQuestionsBulk(Request $request)
    {
        $validated = $request->validate([
            '*.intent_id' => 'required|exists:chatbot_intents,id',
            '*.question_text' => 'required|string',
            '*.input_key' => 'required|string',
            '*.input_type' => 'nullable|string',
            '*.options' => 'nullable|array',
            '*.is_required' => 'boolean',
            '*.order' => 'required|integer',
            '*.info' => 'nullable|string',
        ]);

        ChatbotQuestion::insert($validated);
        return response()->json(['message' => 'Questions inserted successfully'], 201);
    }


     /**
     * Put Question
     *
     * @param  mixed $request
     * @return void
     */
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


        /**
        * Delete Question
        *
        * @param  mixed $request
        * @return void
        */
    // Post questions
    public function deleteQuestion($id)
    {
        $question = ChatbotQuestion::findOrFail($id);
        $question->delete();
        return response()->json(['message' => 'Question deleted']);
    }
}
