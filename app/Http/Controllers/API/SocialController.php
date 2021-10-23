<?php

namespace App\Http\Controllers\API;

use App\Core\API\Services\Contracts\IUserService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class SocialController extends Controller
{
    /* @var IUserService */
    protected $userService;

    public function __construct(IUserService $userService)
    {
        $this->userService = $userService;
    }

    public function redirect()
    {
        $url = Socialite::
        with('github')
            ->stateless()
            ->redirect()
            ->getTargetUrl();

        return response()->json(
            ['status' => true, 'url' => $url]
        );

    }

    public function callback()
    {

        if($userCallback = Socialite::driver('github')->stateless()->user()) {
            // get user by provider id
            $user = $this->userService->byProviderId($userCallback->id);


            // if user exist login in provider
            if ($user) {
                if ($user->token = $user->createToken($user->email)->plainTextToken) {
                    $data = [
                        'user'          => $user,
                        'status'        => true
                    ];

                    //volta para o site tem q setar o localstorage

                    return redirect()->to(env('FRONT_END_SITE') . '?response='. json_encode($data));
                }

            }

            $githubData = [
                'email' => $user->email,
                'password' => Hash::make(Str::random(10)),
                'provider' => 'github',
                'provider_user_id' => $user->id,
                'name' => $user->name,
                'avatar' => $user->avatar,
            ];

            if ($userSaved = $this->userService->save($githubData)) {
                if ($userSaved->token = $userSaved->createToken($userSaved->email)->plainTextToken) {
                    $data = [
                        'status' => true,
                        'user' => $userSaved,
                    ];
                    return redirect()->to(env('FRONT_END_SITE') . '?response='. json_encode($data));
                }
            } else {
                abort(400, 'Erro ao criar usuário');
            }

            return \redirect(env('FRONT_END_SITE'));
        }

        abort(404, 'Usuário não encontrado ou não foi possível criar');
        return \redirect(env('FRONT_END_SITE'));
    }
}
