<?php

namespace App\Http\Controllers\ILoveAustin;

use App\Http\Controllers\ILoveAustin\Services\LoginService;
use Laravel\Lumen\Routing\Controller;

class LoginController extends Controller
{
    private $loginService;

    public function __construct(LoginService $loginService)
    {
        $this->loginService = $loginService;
    }

    public function login(\Illuminate\Http\Request $request)
    {
        return $this->loginService->login($request, $request->json()->get('username'));
    }
}
