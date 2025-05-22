<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * user
     *
     * @param  mixed $request
     * @return void
     */
    public function getUser(Request $request)
    {

        // Return the user as a JSON response
        return response()->json($request->user());
    }
}
