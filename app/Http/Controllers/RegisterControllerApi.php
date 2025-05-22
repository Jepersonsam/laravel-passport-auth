<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterRequest;
//use Illuminate\Support\Facades\Validator;
use App\Http\Responses\RegisterResponse;

class RegisterControllerApi extends Controller
{

    /**
     * register
     *
     * @param  mixed $request
     * @return void
     */

    public function register(RegisterRequest $request)
    {
        //$validated = $request->validated();

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password)
        ]);

        return RegisterResponse::success('Register Succes', $user);
    }
}
