<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Http\Response;
use \Firebase\JWT\JWT;
use Illuminate\Support\Carbon;

class AuthController extends Controller
{
    public function login(Request $request): Response
    {

        $validatedData = $this->validate($request, [
            'username' => 'required|max:255',
            'password' => 'required',
        ]);

        $user = User::where('username', $request->username)->first();
        $hashedPassword = $user->password;
        if (Hash::check($request->password, $hashedPassword)) {
            $payload = array(
                "user_id" => $user->id,
                "username" => $user->username,
                "iat" => Carbon::now('Europe/Paris')->timestamp,
                "exp" => Carbon::now('Europe/Paris')->addDay()->timestamp,
            );

            $jwt = JWT::encode($payload, $_ENV['JWT_SECRET']);
            $decoded = JWT::decode($jwt, $_ENV['JWT_SECRET'], array('HS256'));

            return (new Response(["token" => $jwt, "decoded" => $decoded, Auth::user()], 200))->header('Content-Type', 'application/json');
        }
    }
}
