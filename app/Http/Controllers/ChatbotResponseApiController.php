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


    /**
     * Get Schedule Responses
     */
    public function getScheduleResponse(Request $request): JsonResponse
    {
        $origin = $request->input('origin');
        $destination = $request->input('destination');
        $departureDate = $request->input('departure_date');

        if (!$origin || !$destination || !$departureDate) {
            return response()->json(['error' => 'Origin, destination, dan departure_date wajib diisi.'], 422);
        }

        // Ambil template response dari intent_id = 2
        $response = DB::table('chatbot_responses')
            ->where('intent_id', 2)
            ->first();

        if (!$response) {
            return response()->json(['error' => 'Response tidak ditemukan.'], 404);
        }

        // Ambil jadwal dari tabel schedules
        $schedules = DB::table('schedules')
            ->select('time', 'vehicle')
            ->where('origin', 'like', "%$origin%")
            ->where('destination', 'like', "%$destination%")
            ->where('departure_date', $departureDate)
            ->get();

        if ($schedules->isEmpty()) {
            return response()->json(['text' => 'Tidak ditemukan jadwal keberangkatan untuk rute ini.']);
        }

        // Gabungkan jadwal menjadi satu string
        $scheduleText = $schedules->map(function ($s) {
            return $s->time . ' - ' . $s->vehicle;
        })->implode(', ');

        // Replace placeholder
        $finalText = str_replace(
            ['{origin}', '{destination}', '{departure_date}', '{schedule}'],
            [$origin, $destination, $departureDate, $scheduleText],
            $response->response_text
        );

        return response()->json([
            'text' => $finalText
        ]);
    }

    /**
     * Get Ticket Responses
     */
    public function getTicketPriceResponse(Request $request): JsonResponse
    {
        $origin = $request->input('origin');
        $destination = $request->input('destination');
        $ticket_class = $request->input('ticket_class');

        if (!$origin || !$destination || !$ticket_class) {
            return response()->json(['error' => 'Origin, destination, dan ticket_class wajib diisi.'], 422);
        }

        // Ambil template response dari chatbot_responses untuk intent_id 3
        $response = DB::table('chatbot_responses')
            ->where('intent_id', 3)
            ->first();

        if (!$response) {
            return response()->json(['error' => 'Response tidak ditemukan.'], 404);
        }

        // Ambil harga tiket dari tabel tickets
        $ticket = DB::table('tickets')
            ->where('origin_city', $origin)
            ->where('destination_city', $destination)
            ->where('class', $ticket_class)
            ->orderBy('price', 'asc')
            ->first();

        if (!$ticket) {
            return response()->json(['text' => 'Maaf, tiket untuk kelas tersebut tidak tersedia dari ' . $origin . ' ke ' . $destination . '.']);
        }

        // Ganti placeholder di response_text
        $finalText = str_replace(
            ['{ticket_class}', '{origin}', '{destination}', '{price}'],
            [$ticket_class, $origin, $destination, number_format($ticket->price, 0, ',', '.')],
            $response->response_text
        );

        return response()->json([
            'text' => $finalText,
        ]);
    }
}
