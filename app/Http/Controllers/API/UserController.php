<?php

namespace App\Http\Controllers\API;

use App\Core\API\Services\Contracts\IUserService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /* @var IUserService */
    protected $userService;

    public function __construct(IUserService $userService)
    {
        $this->userService = $userService;
    }

    public function store(Request $request)
    {
        $data = $request->all();

        if ($user = $this->userService->save($data)) {
            if($user->token = $user->createToken($user->email)->plainTextToken ) {
                return response()->json([
                    'status' => true,
                    'user' => $user,
                ]);
            }
        }
        return response()->json(['status', false]);
    }

    public function update(Request $request)
    {
        $data = $request->all();
        if ($user = $this->userService->save($data)) {

            if($user->token = $user->createToken($user->email)->plainTextToken ) {
                return response()->json([
                    'status' => true,
                    'user' => $user
                ]);
            }
        }
        return response()->json(['status' => false]);
    }

    public function login(Request $request)
    {
        if ($user = $this->userService->login($request)) {
            if($user->token = $user->createToken($user->email)->plainTextToken ) {
                return response()->json([
                    'status' => true,
                    'user' => $user
                ]);
            }
            return response()->json(['status' => false, 'message' => 'Não foi possível criar um token!']);
        }
        return response()->json(['status' => false, 'message' => 'Combinação de email e senha incorretos!']);
    }

    public function logout()
    {
        return response()->json([
            'status' => true,
            'logged_out' => $this->userService->logout()
        ]);
    }
}
