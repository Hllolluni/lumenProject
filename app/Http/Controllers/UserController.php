<?php

namespace App\Http\Controllers;

use App\Models\User_details;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Services\UtilityService;
use App\Http\Requests\UserRegisterRequest;
use App\Http\Requests\UserLoginRequest;
use Illuminate\Support\Facades\Auth;

use SebastianBergmann\Diff\Exception;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;


class UserController extends Controller
{

    public function register(Request $request){
        $firstName = $request->firstName;
        $lastName = $request->lastName;
        $age = $request->age;
        $email = $request->email;
        $password = $request->password;

        if(empty($firstName) or empty($lastName) or empty($age) or empty($email) or empty($password)){
            return response()->json(['status'=>'error','message'=>'You must fill all the fields']);
        }

        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            return response()->json(['status'=>'error','message'=>'You must enter a valid email']);
        }

        if(strlen($password) < 8){
            return response()->json(['status'=>'error','message'=>'Password must be at least 6 characters']);
        }

        if(User::where('email','=',$email)->exists()){
            return response()->json(['status'=>'error','message'=>'User already exists with this email']);
        }

        try{
            $user = new User();
            $user->firstName = $request->firstName;
            $user->lastName = $request->lastName;
            $user->age= $request->age;
            $user->email = $request->email;
            $user->password = app('hash')->make($request->password);

            if ($user->save()){
                return $this->login($request);
            }
        }catch (\Exception $exception){
            return response()->json(['status'=>'error','message'=>$exception->getMessage()]);
        }
    }


    public function login(Request $request)
    {
        $email = $request->email;
        $password = $request->password;
        $credentials = request(['email', 'password']);

        if(empty($email) or empty($password)){
            return response()->json(['status'=>'error','message'=>'You must fill all the fields']);
        }

        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
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
