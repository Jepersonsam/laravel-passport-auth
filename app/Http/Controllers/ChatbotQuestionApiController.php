<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreQuestionRequest;
use App\Http\Requests\StoreQuestionBulkRequest;
use App\Http\Requests\UpdateQuestionRequest;
use App\Http\Requests\UpdateIntentRequest;
use App\Http\Resources\ChatbotQuestionResource;
use Illuminate\Http\JsonResponse;
use App\Models\ChatbotQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Js;

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
    public function getQuestions(int $intent_id): JsonResponse
    {
        $questions = ChatbotQuestion::where('intent_id', $intent_id)->orderBy('order')->get();
        return response()->json([
            'success' => true,
            'message' => 'Questions retrieved successfully',
            'data' => ChatbotQuestionResource::collection($questions),
        ]);
    }

    public function index()
    {
        return ChatbotQuestion::with('intent')->paginate(50);
        
    }

    /**
     * Post Question
     *
     * @param  mixed $request
     * @return void
     */
    //Post Question
    public function createQuestions(StoreQuestionRequest $request): JsonResponse
    {
        $questions = ChatbotQuestion::create($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Question created successfully',
            'data' => new ChatbotQuestionResource($questions),
        ], 201);
    }


    /**
     * Post Question Bulk
     *
     * @param  mixed $request
     * @return void
     */
    public function storeQuestionsBulk(StoreQuestionBulkRequest $request): JsonResponse
    {
        $questions = ChatbotQuestion::insert($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Question created successfully',
            'data' => new ChatbotQuestionResource($questions),
        ], 201);
    }


    /**
     * Put Question
     *
     * @param  mixed $request
     * @return void
     */
    // PUT questions
    public function updateQuestions(UpdateQuestionRequest $request,int $id): JsonResponse
    {
        $question = ChatbotQuestion::find($id);
        if (!$question) return response()->json(['message' => 'Question not found'], 404);

        $question->update($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Question updated successfully',
            'data' => new ChatbotQuestionResource($question),
        ], 201);
    }


    /**
     * Delete Question
     *
     * @param  mixed $request
     * @return void
     */
    // Post questions
    public function deleteQuestion(int $id)
    {
        $question = ChatbotQuestion::findOrFail($id);
        $question->delete();
        return response()->json([
            'success' => "OK",
            'error' => null,
            'status' => 200,
            'data' => null,
            'message' => 'Question deleted']);
    }
}
