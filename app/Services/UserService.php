<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;

class UserService
{
    public function login(array $data):  bool
    {
        return (Auth::attempt([
            "email" => $data["email_username"],
            "password"=> $data["password"]
        ]) || Auth::attempt([
            "username" => $data["email_username"],
            "password"=> $data["password"]
        ]));
    }

    public function logout(array $data)
    {
        Auth::logout();
    }
}
