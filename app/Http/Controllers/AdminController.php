<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminLoginRequest;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Env;
use Illuminate\Validation\ValidationException;
use PhpParser\Node\Expr\FuncCall;

class AdminController extends Controller
{
    private UserService $userServive;

    public function __construct(UserService $userService)
    {
        $this->userServive = $userService;
    }

    public function login(Request $request)
    {
        $key = $request->get("key");

        if ($key != Env::get("ADMIN_PAGE_KEY")) {
            abort(404);
        }

        return response()->view('admin.login');
    }

    public function postLogin(AdminLoginRequest $request)
    {
        $key = $request->get("key");

        if ($key != Env::get("ADMIN_PAGE_KEY")) {
            abort(404);
        }

        $data = $request->validated();

        $success = $this->userServive->login($data);

        if ($success) {
            return response()->redirectTo('/');
        } else {
            return redirect()->back()->withErrors([
                'login' => ['Username or email or password is incorrect']
            ]);
        }
    }
}
