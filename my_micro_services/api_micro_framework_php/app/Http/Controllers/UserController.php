<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
// use Illuminate\Http\Client\Response;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Firebase\JWT\JWT;

class UserController extends Controller
{

    public function profile()
    {
        $userMessages = User::find(Auth::id())->messages;
        return (new Response($userMessages, 200))->header('Content-Type', 'application/json');
    }

    public function store(Request $request)
    {
        $user = new User;

        $validatedData = $this->validate($request, [
            'nom' => 'required|max:255',
            'prenom' => 'required|max:255',
            'email' => 'required|unique:user|max:255',
            'username' => 'required|unique:user|max:255',
            'password' => 'required',
        ]);

        $user->fill($request->except('password'));
        $user->password = Hash::make($request->password);
        $user->save();
    }

    public function show(): Response
    {
        $user = User::find(Auth::id());
        if ($user) {
            return (new Response($user, 200))->header('Content-Type', 'application/json');
        } else {
            $message = "probleme";
            return (new Response($message, 422))->header('Content-Type', 'application/json');
        }
    }

    public function edit(User $User)
    {
    }

    public function update(Request $request): Response
    {
        $this->validate($request, [
            'nom' => 'required | max:255',
            'prenom' => 'required | max:255',
            'email' => 'required | max:255',
            'password' => 'required | max:255',
            'username' => 'required | max:255',
        ]);

        $user = User::find(Auth::id());
        if (Hash::check($request->password, $user->password)) {
            $user->fill($request->except('password'));
            $user->password = Hash::make($request->password);
            $user->save();

            $payload = array(
                "user_id" => $user->id,
                "username" => $request->username,
                "iat" => Carbon::now('Europe/Paris')->timestamp,
                "exp" => Carbon::now('Europe/Paris')->addDay()->timestamp,
            );

            $jwt = JWT::encode($payload, $_ENV['JWT_SECRET']);
            $decoded = JWT::decode($jwt, $_ENV['JWT_SECRET'], array('HS256'));
            return (new Response([$decoded], 200))->header('Content-Type', 'application/json');
        } else {
            return (new Response($request, 422))->header('Content-Type', 'application/json');
        }
    }


    public function delete(Request $request): Response
    {
        $user = User::find(Auth::id());

        $this->validate($request, [
            'username' => 'required | max:255',
            'password' => 'required | max:255',
            'confirm_password' => 'required | max:255',
        ]);

        if ($user->username == $request->username && Hash::check($request->password, $user->password) && $request->password == $request->confirm_password) {

            $user->delete();
            return (new Response(200))->header('Content-Type', 'application/json');
        } else {
            return (new Response(422))->header('Content-Type', 'application/json');
        }
    }
}
