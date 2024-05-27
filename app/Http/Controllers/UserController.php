<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index(Request $request)
    {
        return new UserCollection(User::all());
    }

    public function show(User $user, Request $request)
    {
        $includeTasks = $request->query('includeTasks');
        if ($includeTasks) {
            return new UserResource($user->loadMissing('tasks'));
        }
        return new UserResource($user);
    }

    public function login(LoginRequest $request)
    {
        $data = $request->validated();

        if (!Auth::attempt($data)) {
            return response([
                'message' => 'email or password are wrong'
            ]);
        }
        $user = Auth::user();

        if ($user->role === 'admin') {
            $token = $user->createToken('admin', [
                'place-tasks',
                'check-tasks',
                'update-tasks',
                'delete-tasks',
                'see-users'
            ])->accessToken;
        } else {
            $token = $user->createToken('user', [
                'place-tasks',
                'check-tasks',
                'update-tasks'
            ])->accessToken;
        }

        return response()->json([
            'message' => "Welcome " . $user->name,
            'access_token' => $token
        ]);

    }

    public function register(RegisterRequest $request)
    {
        $data = $request->validated();

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),

        ]);

        return response()->json([
            'message' => "Welcome " . $user->name . " your account was registered successfully.",
        ]);
    }

    public function logout(Request $request)
    {
        $user = $request->user();

        $user->currentAccessToken()->delete();

        return response('Loggout Successfully', 204);
    }
}
