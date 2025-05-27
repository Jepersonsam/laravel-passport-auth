<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

use App\Http\Controllers\ChatbotIntentApiController;
use App\Http\Controllers\ChatbotQuestionApiController;
use App\Http\Controllers\ChatbotResponseApiController;
use App\Http\Controllers\LoginControllerApi;
use App\Http\Controllers\RegisterControllerApi;
use App\Http\Controllers\UserController;



// 🧑‍💻 Auth & User
Route::post('/register', [RegisterControllerApi::class, 'register']);
Route::post('/login', [LoginControllerApi::class, 'login']);
Route::get('/user', [UserController::class, 'getUser'])->middleware('auth:api');

// 🔁 Fetch dari webhook n8n
Route::get('/get-user', function () {
    $webhookUrl = 'http://localhost:32769/webhook-test/1ec6c84f-c751-419e-b5f5-544bb356840f';

    $response = Http::get($webhookUrl);

    if ($response->successful()) {
        return response()->json([
            'message' => 'Data fetched successfully from n8n webhook!',
            'data' => $response->json(),
        ], 200);
    }

    return response()->json([
        'error' => 'Failed to fetch data from webhook.',
        'details' => $response->body(),
    ], 500);
});


Route::middleware(['auth:api'])->group(function () {


// 🤖 Chatbot Intents\
Route::get('/chatbot/intents', [ChatbotIntentApiController::class, 'getIntents']);
Route::post('/chatbot/intents', [ChatbotIntentApiController::class, 'storeIntent']);
Route::put('/chatbot/intents/{id}', [ChatbotIntentApiController::class, 'updateIntent']);
Route::delete('/chatbot/intents/{id}', [ChatbotIntentApiController::class, 'deleteIntent']);


// ❓ Chatbot Questions
Route::get('/chatbot/questions', [ChatbotQuestionApiController::class, 'index']);
Route::get('/chatbot/questions/{intent_id}', [ChatbotQuestionApiController::class, 'getQuestions']);
Route::post('/chatbot/questions', [ChatbotQuestionApiController::class, 'createQuestions']);
Route::put('/chatbot/questions/{id}', [ChatbotQuestionApiController::class, 'updateQuestions']);
Route::delete('/chatbot/questions/{id}', [ChatbotQuestionApiController::class, 'deleteQuestion']);
Route::post('/chatbot/questions/bulk', [ChatbotQuestionApiController::class, 'storeQuestionsBulk']);
Route::post('/chatbot/questions/{id}/order', [ChatbotQuestionApiController::class, 'updateQuestionsOrder']);


// 💬 Chatbot Responses (✅ sudah dibetulkan controllernya)
Route::get('/chatbot/responses', [ChatbotResponseApiController::class, 'index']);
Route::get('/chatbot/responses/{intent_id}', [ChatbotResponseApiController::class, 'getResponse']);
Route::post('/chatbot/responses', [ChatbotResponseApiController::class, 'createResponse']);
Route::put('/chatbot/responses/{id}', [ChatbotResponseApiController::class, 'updateResponse']);
Route::delete('/chatbot/responses/{id}', [ChatbotResponseApiController::class, 'deleteResponse']);

});


