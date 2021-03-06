<?php

namespace App\Core\API\Services;

use App\Core\API\Repositories\Contracts\IUserRepository;
use App\Core\API\Services\Contracts\IUserService;
use App\Core\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserService implements IUserService
{
    /* @var IUserRepository */
    protected $userRepository;

    public function __construct(IUserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function byProviderId(string $id): ?User
    {
        return $this->userRepository->byProviderId($id);
    }


    public function byEmail(string $email): ?User
    {
        return $this->userRepository->byEmail($email);
    }

    public function save(array $data): ?User
    {
        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

//        if(isset($data['image'])) {
//
//            if (isset($data['id'])) {
//                $user = $this->userRepository->byId($data['id']);
//
//                if ($user && $user->image != null) {
//                    Storage::disk('profiles')->delete($user->getAttributes()['image']);
//                }
//            }
//
//
//            $imageBase64 = $data['image'];
//            @list($type, $file_data) = explode(';', $imageBase64);
//            @list(, $file_data) = explode(',', $file_data);
//
//            $imageName = Str::random(5) . time() .'.'.'png';
//
//            Storage::disk('profiles')->put($imageName, base64_decode($file_data));
//
//            $data['image'] = $imageName;
//        } else {
//            unset($data['image']);
//        }


        if ( $user = $this->userRepository->save($data) ) {
            return $user;
        }

        return NULL;
    }

    public function login(Request $request): ?User
    {
        $email      = $request->input('email');
        $password   = $request->input('password');
        $user       = $this->userRepository->byEmail($email);

        if ($user  &&  Hash::check($password, $user->makeVisible('password')->password)) {
            auth()->login($user);
            return $user;
        }
        return NULL;

    }

    public function logout(): bool
    {
        if (auth()->user()) {
            auth()->user()->tokens()->delete();
            auth()->logout();
            return true;
        }

        return false;
    }
}
