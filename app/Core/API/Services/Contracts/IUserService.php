<?php

namespace App\Core\API\Services\Contracts;

use App\Core\Models\User;
use Illuminate\Http\Request;

interface IUserService
{
    public function save(array $data): ?User;
    public function login(Request $request): ?User;
    public function logout(): bool;
    public function byEmail(string $email): ?User;
    public function byProviderId(string $id) : ?User;
}
