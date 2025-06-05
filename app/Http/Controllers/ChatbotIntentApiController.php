<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreIntentRequest;
use App\Http\Requests\UpdateIntentRequest;
use App\Http\Resources\ChatbotIntentResource;
use App\Models\ChatbotIntent;
use Illuminate\Http\JsonResponse;

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
        return response()->json([
            'success' => true,
            'message' => 'Intents retrieved successfully',
            'data' => ChatbotIntentResource::collection(ChatbotIntent::all()),
        ]);
    }

    

    /**
     * Post Intent
     *
     * @param  mixed $request
     * @return void
     */
    public function storeIntent(StoreIntentRequest $request): JsonResponse
    {
        $intent = ChatbotIntent::create($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Intent created successfully',
            'data' => new ChatbotIntentResource($intent),
        ], 201);
    }
    /**
     * Put Intent
     *
     * @param  mixed $request
     * @return void
     */
    // PUT intents
    public function updateIntent(UpdateIntentRequest $request,int $id): JsonResponse
    {
        $intent = ChatbotIntent::find($id);

        if (!$intent) {
            return response()->json([
                'success' => false,
                'message' => 'Intent not found',
            ], 404);
        }

        $intent->update($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Intent updated successfully',
            'data' => new ChatbotIntentResource($intent),
        ]);
    }
    /**
     * Delete Intent
     *
     * @param  mixed $request
     * @return void
     */
    // DELETE intents
    public function deleteIntent(int $id)
    {
        $intent = ChatbotIntent::find($id);
        if (!$intent) return response()->json(['message' => 'Intent not found'], 404);
        $intent->delete();
        return response()->json([
            'success' => "OK",
            'error' => null,
            'status' => 200,
            'data' => null,
            'message' => 'Question deleted'
        ]);
    }
}
