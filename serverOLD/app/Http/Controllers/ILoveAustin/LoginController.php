<?php

namespace App\Http\Controllers\ILoveAustin;

class LoginController extends ControllerBase
{
    public function login(\Illuminate\Http\Request $request)
    {
        return $this->services->login->login($request, $this->getRequestValue($request,'username'));
    }
}
