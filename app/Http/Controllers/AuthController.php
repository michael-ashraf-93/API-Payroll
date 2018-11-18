<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\JWTAuth;

class AuthController extends Controller
{


    use AuthenticatesUsers;
    private $jwtauth;
    private $user;


    public function __construct(User $user, JWTAuth $jwtauth)
    {
        $this->jwtauth = $jwtauth;
        $this->user = $user;
        $this->middleware('jwt.auth', ['except' => ['login', 'newUserWizard']]);
    }

    public function newUserWizard(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), 200);
        }
        else {
            $newUser = $this->user->create([
                'name' => $request->first_name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ]);


            if (!$newUser) {
                return response()->json([trans('api.failed_to_create_new_user')], 500);
            }
            return response()
                ->json([
                    'token' => $this->jwtauth->fromUser($newUser),
                    'user' => $newUser
                ]);
        }
    }

    public function login(Request $request)
    {
        // get user credentials: email, password
        $credentials = $request->only('email', 'password');
        $token = null;
        try {
            $token = $this->jwtauth->attempt($credentials);
            if (!$token) {
                return response()->json('Invalid email or password', 400);
            }
        } catch (JWTAuthException $e) {
            return response()->json('Failed to create token', 500);

        }
//        return response()->json(compact('token', 'user'));
        return response()->json(compact("token", "user"));

    }


    public function logout()
    {
        $this->jwtauth->invalidate($this->jwtauth->getToken());
        $returnData = array(
            'success' => 'Come back soon :)',
        );
        return response()->json($returnData);
    }


}

