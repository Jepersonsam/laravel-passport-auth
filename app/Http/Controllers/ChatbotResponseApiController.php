<?php

namespace App\Http\Controllers;

use App\Models\ChatbotResponse;
use App\Http\Requests\StoreResponseRequest;
use App\Http\Requests\UpdateResponseRequest;
use App\Http\Resources\ChatbotResponseResource;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
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
     public function index()
    {
        return ChatbotResponse::with('intent')->paginate(50);
        
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


    
    /**
     * Get Route Responses
     */
    public function getRouteResponse(Request $request)
    {
        $origin = $request->input('origin');
        $destination = $request->input('destination');

        if (!$origin || !$destination) {
            return response()->json(['error' => 'Origin dan Destination wajib diisi.'], 422);
        }

        // Ambil query dari chatbot_responses untuk intent id = 1 (misal: rute)
        $response = DB::table('chatbot_responses')
            ->where('intent_id', 1)
            ->first();

        if (!$response) {
            return response()->json(['error' => 'Response tidak ditemukan.'], 404);
        }

        // Query route
        $route = DB::selectOne("
            SELECT name FROM routes 
            WHERE origin LIKE ? AND destination LIKE ?
            LIMIT 1
        ", ["%$origin%", "%$destination%"]);

        $routeName = $route->name ?? 'tidak diketahui';

        // Replace placeholder di response_text
        $finalText = str_replace(
            ['{origin}', '{destination}', '{name}'],
            [$origin, $destination, $routeName],
            $response->response_text
        );

        return response()->json([
            'text' => $finalText
        ]);
    }
}

