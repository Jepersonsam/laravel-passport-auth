<?php

namespace App\Http\Controllers;

use App\Models\ChatbotResponse;
use App\Http\Requests\StoreResponseRequest;
use App\Http\Requests\UpdateResponseRequest;
use App\Http\Resources\ChatbotResponseResource;
use Illuminate\Http\JsonResponse;

class ChatbotResponseApiController extends Controller
{
    /**
     * Get Response By Intent ID
     */
    public function getResponse(int $intent_id): JsonResponse
    {
        $response = ChatbotResponse::where('intent_id', $intent_id)->get();
        return response()->json([
            'success' => true,
            'message' => 'Response retrieved successfully',
            'data' => ChatbotResponseResource::collection($response),
        ]);
    }

    /**
     * Create Response
     */
    public function createResponse(StoreResponseRequest $request): JsonResponse
    {
        $response = ChatbotResponse::create($request->validated());
        return response()->json([
            'success' => true,
            'message' => 'Response created successfully',
            'data' => new ChatbotResponseResource($response),
        ], 201);
    }

    /**
     * Update Response
     */
    public function updateResponse(UpdateResponseRequest $request, int $id): JsonResponse
    {
        $response = ChatbotResponse::find($id);

        if (!$response) {
            return response()->json(['message' => 'Response not found'], 404);
        }

        $response->update($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Response updated successfully',
            'data' => new ChatbotResponseResource($response),
        ]);
    }

    /**
     * Delete Response
     */
    public function deleteResponse(int $id): JsonResponse
    {
        $response = ChatbotResponse::findOrFail($id);
        $response->delete();

        return response()->json([
            'success' => true,
            'error' => null,
            'status' => 200,
            'data' => null,
            'message' => 'Response deleted successfully',
        ]);
    }
}
