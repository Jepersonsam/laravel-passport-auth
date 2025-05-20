<?php

use App\Http\Controllers\LoginControllerApi;
use App\Http\Controllers\RegisterControllerApi;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ChatbotController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

Route::get('/user', [UserController::class, 'getUser'])->middleware('auth:api');

Route::get('/get-user', function () {
    // Panggil URL webhook di n8n (sesuaikan dengan workflow Anda)
    $webhookUrl = 'http://localhost:32769/webhook-test/1ec6c84f-c751-419e-b5f5-544bb356840f'; // Ganti jika berbeda
   
    // Kirimkan permintaan GET ke webhook
    $response = Http::get($webhookUrl);

    // Periksa jika permintaan berhasil
    if ($response->successful()) {
        return response()->json([
            'message' => 'Data fetched successfully from n8n webhook!',
            'data' => $response->json(), // Ambil data langsung dari response
        ], 200);
    }

    // Jika gagal
    return response()->json([
        'error' => 'Failed to fetch data from webhook.',
        'details' => $response->body(), // Tampilkan detail error untuk debugging
    ], 500);
});

Route::post('/register', [RegisterControllerApi::class, 'register']);
Route::post('/login', [LoginControllerApi::class, 'login']);


//Intents
Route::get('/chatbot/intents', [ChatbotController::class, 'getIntents']);
Route::post('/chatbot/intents', [ChatbotController::class, 'createIntent']);
Route::put('/chatbot/intents/{id}', [ChatbotController::class, 'updateIntent']);
Route::delete('/chatbot/intents/{id}', [ChatbotController::class, 'deleteIntent']);


//Questions
Route::get('/chatbot/questions/{intent_id}', [ChatbotController::class, 'getQuestions']);
Route::post('/chatbot/questions', [ChatbotController::class, 'createQuestions']);
Route::put('/chatbot/questions/{id}', [ChatbotController::class, 'updateQuestions']);
Route::delete('/chatbot/questions/{id}', [ChatbotController::class, 'deleteQuestion']);
Route::post('/chatbot/questions/bulk', [ChatbotController::class, 'storeQuestionsBulk']);
Route::post('/chatbot/questions/{id}/order', [ChatbotController::class, 'updateQuestionsOrder']);



//Responses
Route::get('/chatbot/responses/{intent_id}', [ChatbotController::class, 'getResponse']);
Route::post('/chatbot/responses', [ChatbotController::class, 'createResponse']);
Route::put('/chatbot/responses/{id}', [ChatbotController::class, 'updateResponse']);
Route::delete('/chatbot/responses/{id}', [ChatbotController::class, 'deleteResponse']);


