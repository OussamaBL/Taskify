<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Dotenv\Validator;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    /**
 * @OA\Post(
 *     path="/register",
 *     operationId="registerUser",
 *     tags={"Authentication"},
 *     summary="Register a new user",
 *     description="Register a new user with the provided name, email, and password.",
 *     @OA\RequestBody(
 *         required=true,
 *         description="User registration details",
 *         @OA\JsonContent(ref="#/components/schemas/RegisterRequest")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="User created successfully",
 *         @OA\JsonContent(
 *             @OA\Property(
 *                 property="status",
 *                 type="integer",
 *                 example=200
 *             ),
 *             @OA\Property(
 *                 property="message",
 *                 type="string",
 *                 example="User created successfully"
 *             ),
 *             @OA\Property(
 *                 property="token",
 *                 type="string",
 *                 example="generated_token_here"
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Server error",
 *         @OA\JsonContent(
 *             @OA\Property(
 *                 property="status",
 *                 type="integer",
 *                 example=500
 *             ),
 *             @OA\Property(
 *                 property="message",
 *                 type="string",
 *                 example="Internal server error"
 *             )
 *         )
 *     )
 * )
 */
    public function register(RegisterRequest $request){
        try{
            $register=$request->validated();
            $user=User::create([
                'name'=>$register['name'],
                'email'=>$register['email'],
                'password'=> Hash::make($register['password']),
            ]);
            $token=$user->createToken('Api Token')->plainTextToken;
            return response()->json([
                'status'=>200,
                'message'=>'User created successfully',
                'token'=> $token,
            ],200);
            
        }
        catch(Exception $e){
            return response()->json([
                "status"=>500,
                "message"=> $e->getMessage(),
            ],500);
        }
    }
/**
 * @OA\Post(
 *     path="/api/login",
 *     operationId="loginUser",
 *     tags={"Authentication"},
 *     summary="Log in as a user",
 *     description="Log in with the provided email and password.",
 *     @OA\RequestBody(
 *         required=true,
 *         description="User login details",
 *         @OA\JsonContent(ref="#/components/schemas/LoginRequest")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="User logged in successfully",
 *         @OA\JsonContent(
 *             @OA\Property(
 *                 property="status",
 *                 type="integer",
 *                 example=200
 *             ),
 *             @OA\Property(
 *                 property="message",
 *                 type="string",
 *                 example="User logged in successfully"
 *             ),
 *             @OA\Property(
 *                 property="Informations User",
 *                 ref="#/components/schemas/User"
 *             ),
 *             @OA\Property(
 *                 property="token",
 *                 type="string",
 *                 example="generated_token_here"
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized",
 *         @OA\JsonContent(
 *             @OA\Property(
 *                 property="status",
 *                 type="integer",
 *                 example=401
 *             ),
 *             @OA\Property(
 *                 property="message",
 *                 type="string",
 *                 example="email or password incorrect"
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Server error",
 *         @OA\JsonContent(
 *             @OA\Property(
 *                 property="status",
 *                 type="integer",
 *                 example=500
 *             ),
 *             @OA\Property(
 *                 property="message",
 *                 type="string",
 *                 example="Internal server error"
 *             )
 *         )
 *     )
 * )
 */
    public function login(LoginRequest $request){
        try{
            $login=$request->validated();
            if(Auth::attempt(['email'=>$request->email,'password'=>$request->password])){
                $user=User::where('email',$login['email'])->first();
                $token=$user->createToken('Api Token')->plainTextToken;
                return response()->json([
                    "status"=>200,
                    "message"=> "User logged in successfully",
                    "Informations User"=>$user,
                    "token"=> $token,
                ],200);
            }
            else{
                return response()->json([
                    "status"=>401,
                    "message"=> "email or password incorrect",
                ],401);
            }
        }
        catch(Exception $e){
            return response()->json([
                "status"=>500,
                "message"=> $e->getMessage(),
            ],500);
        }
    }
    /**
 * @OA\Post(
 *     path="/logout",
 *     operationId="logoutUser",
 *     tags={"Authentication"},
 *     summary="Log out the current user",
 *     description="Log out the currently authenticated user.",
 *     security={{"bearerAuth":{}}},
 *     @OA\Response(
 *         response=200,
 *         description="User logged out successfully",
 *         @OA\JsonContent(
 *             @OA\Property(
 *                 property="status",
 *                 type="integer",
 *                 example=200
 *             ),
 *             @OA\Property(
 *                 property="message",
 *                 type="string",
 *                 example="User logged out successfully"
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Unauthorized",
 *         @OA\JsonContent(
 *             @OA\Property(
 *                 property="status",
 *                 type="integer",
 *                 example=201
 *             ),
 *             @OA\Property(
 *                 property="message",
 *                 type="string",
 *                 example="Unauthorized"
 *             )
 *         )
 *     )
 * )
 */
    public function logout(Request $request){
        if(Auth::check()){
            auth()->user()->tokens()->delete();
            return response()->json([
                "status"=>200,
                "message"=> 'User Logout successfully',
            ],200);
        }
        else{
            return response()->json([
                "status"=>201,
                "message"=> 'Unauthorized',
            ],201);
        }
    }
}
