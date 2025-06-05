<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RegisterControllerApi;
use App\Http\Controllers\LoginControllerApi;
use App\Http\Controllers\ChatbotIntentApiController;
use App\Http\Controllers\ChatbotQuestionApiController;
use App\Http\Controllers\ChatbotResponseApiController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\RouteController;
use App\Models\User;
use GuzzleHttp\Middleware;
use Illuminate\Routing\RouteRegistrar;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Http;


// 🧑‍💻 Auth & User
Route::post('/register', [RegisterControllerApi::class, 'register']);
Route::post('/login', [LoginControllerApi::class, 'login']);

// User routes (tanpa apiResource)
Route::middleware(['auth:api'])->group(function () {

    // User routes
    Route::middleware('can:view-user')->group(function () {
        Route::get('/users', [UserController::class, 'index']);
        Route::get('/users/{id}', [UserController::class, 'show']);
    });
    Route::post('/users', [UserController::class, 'store'])->middleware('can:create-user');
    Route::put('/users/{id}', [UserController::class, 'update'])->middleware('can:edit-user');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->middleware('can:delete-user');

    // Permission routes
    Route::middleware('can:view-permission')->group(function () {
        Route::get('/permissions', [PermissionController::class, 'index']);
        Route::get('/permissions/{id}', [PermissionController::class, 'show']);
    });
    Route::post('/permissions', [PermissionController::class, 'store'])->middleware('can:create-permission');
    Route::put('/permissions/{id}', [PermissionController::class, 'update'])->middleware('can:edit-permission');
    Route::delete('/permissions/{id}', [PermissionController::class, 'destroy'])->middleware('can:delete-permission');

    // Role routes
    Route::middleware('can:view-role')->group(function () {
        Route::get('/roles', [RoleController::class, 'index']);
        Route::get('/roles/only-names', [RoleController::class, 'onlyNames']);
        Route::get('/roles/{id}', [RoleController::class, 'show']);
    });
    Route::post('/roles', [RoleController::class, 'store'])->middleware('can:create-role');
    Route::put('/roles/{id}', [RoleController::class, 'update'])->middleware('can:edit-role');
    Route::delete('/roles/{id}', [RoleController::class, 'destroy'])->middleware('can:delete-role');




    // 🔁 Fetch dari webhook n8n
    // Route::get('/get-user', function () {
    //     $webhookUrl = 'http://localhost:32769/webhook-test/1ec6c84f-c751-419e-b5f5-544bb356840f';

    //     $response = Http::get($webhookUrl);

    //     if ($response->successful()) {
    //         return response()->json([
    //             'message' => 'Data fetched successfully from n8n webhook!',
    //             'data' => $response->json(),
    //         ], 200);
    //     }

    //     return response()->json([
    //         'error' => 'Failed to fetch data from webhook.',
    //         'details' => $response->body(),
    //     ], 500);
    // });





    // 🤖 Chatbot Intents
    Route::get('/chatbot/intents', [ChatbotIntentApiController::class, 'getIntents'])->middleware('can:view-intent');
    Route::post('/chatbot/intents', [ChatbotIntentApiController::class, 'storeIntent'])->middleware('can:create-intent');
    Route::put('/chatbot/intents/{id}', [ChatbotIntentApiController::class, 'updateIntent'])->middleware('can:edit-intent');
    Route::delete('/chatbot/intents/{id}', [ChatbotIntentApiController::class, 'deleteIntent'])->middleware('can:delete-intent');

    // ❓ Chatbot Questions
    Route::get('/chatbot/questions', [ChatbotQuestionApiController::class, 'index'])->middleware('can:view-question');
    Route::get('/chatbot/questions/{intent_id}', [ChatbotQuestionApiController::class, 'getQuestions'])->middleware('can:view-question');
    Route::post('/chatbot/questions', [ChatbotQuestionApiController::class, 'createQuestions'])->middleware('can:create-question');
    Route::put('/chatbot/questions/{id}', [ChatbotQuestionApiController::class, 'updateQuestions'])->middleware('can:edit-question');
    Route::delete('/chatbot/questions/{id}', [ChatbotQuestionApiController::class, 'deleteQuestion'])->middleware('can:delete-question');
    Route::post('/chatbot/questions/bulk', [ChatbotQuestionApiController::class, 'storeQuestionsBulk'])->middleware('can:create-question');
    Route::post('/chatbot/questions/{id}/order', [ChatbotQuestionApiController::class, 'updateQuestionsOrder'])->middleware('can:edit-question');

    // 💬 Chatbot Responses
    Route::get('/chatbot/responses', [ChatbotResponseApiController::class, 'index'])->middleware('can:view-response');
    Route::get('/chatbot/responses/{intent_id}', [ChatbotResponseApiController::class, 'getResponse'])->middleware('can:view-response');
    Route::post('/chatbot/responses', [ChatbotResponseApiController::class, 'createResponse'])->middleware('can:create-response');
    Route::put('/chatbot/responses/{id}', [ChatbotResponseApiController::class, 'updateResponse'])->middleware('can:edit-response');
    Route::delete('/chatbot/responses/{id}', [ChatbotResponseApiController::class, 'deleteResponse'])->middleware('can:delete-response');
});

Route::post('/chatbot/route-response', [ChatbotResponseApiController::class, 'getRouteResponse']);
Route::get('/chatbot/schedule', [ChatbotResponseApiController::class, 'getScheduleResponse']);
Route::get('/ticket-price', [ChatbotResponseApiController::class, 'getTicketPriceResponse']);
