<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Http\Services\UtilityService;
use App\Http\Requests\AdminRegisterRequest;
use App\Http\Requests\AdminLoginRequest;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;


class AdminController extends Controller
{

    protected $admin;
    protected $utilityService;

    public function __construct()
    {
        $this->middleware("auth:admin", ["except" => ["login", "register"]]);
        $this->admin = new Admin;
        $this->utilityService = new UtilityService;

    }
    public function register(AdminRegisterRequest $request)
    {
        $password_hash = $this->utilityService->hash_password($request->password);
        $this->admin->createAdmin($request, $password_hash);
        $success_message = "registration completed successfully";
        return $this->utilityService->is200Response($success_message);
    }

    public function login(AdminLoginRequest $request)
    {
        $credentials = $request->only(['email', 'password']);

        if (! $token = Auth::guard('admin')->attempt($credentials)) {
            $responseMessage = "invalid username or password";
            return $this->utilityService->is422Response($responseMessage);
        }
        return $this->respondWithToken($token);
    }

    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }



    public function tokenExpirationException($responseMessage)
    {
        return $this->utilityService->is422Response($responseMessage);
    }


}
