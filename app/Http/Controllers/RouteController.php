<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RouteController extends Controller
{
    public function findRoute(Request $request)
    {
        $request->validate([
            'origin' => 'required|string',
            'destination' => 'required|string',
        ]);

        $origin = $request->input('origin');
        $destination = $request->input('destination');

        $route = DB::table('routes')
            ->where('origin', 'LIKE', "%{$origin}%")
            ->where('destination', 'LIKE', "%{$destination}%")
            ->first();

        if ($route) {
            return response()->json([
                'success' => true,
                'name' => $route->name,
                'origin' => $route->origin,
                'destination' => $route->destination,
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Rute tidak ditemukan.',
        ], 404);
    }
}
