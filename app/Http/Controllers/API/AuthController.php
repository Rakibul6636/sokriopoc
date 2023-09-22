<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Auth;
use Validator;
use Hash;
class AuthController extends Controller
{   //Show the Registration form.
    public function showRegister(){
        return view('register');
    }
    //Show the Login form.
    public function showLogin(){
       return view('login');
    }
    //Register a User.
    public function register(Request $request){
        //validation of input data
        $validator = validator::make($request->all(),[
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
        if($validator->fails()){
            $response = [
                'sucess' => false,
                'message' => $validator->errors()
            ];
            return response()->json($response, 400);
        }
        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        $user = User::create($input);
        $success['token'] = $user->createToken('MyAPP')->plainTextToken;
        $success['name'] = $user->name;
        $response = [
            'success' =>true,
            'data' => $success,
            'message' => 'User register sucessful'
        ];
        return response()->json($response, 200);
    }
    //Log in 
    public function login(Request $request){
        if(Auth::attempt(['email'=> $request->email, 'password' => $request->password])){
            $user = Auth::user();
            $success['token'] = $user->createToken('MyAPP')->plainTextToken;
            $success['name'] = $user->name;
            $response = [
                'success' => true,
                'data' => $success,
                'message' => "User login successfully"
            ];

        if ($response['success']) {
            // Store the token in the session
            session(['api_token' => $response['data']['token']]);
        }

            return response()->json($response,200);
            
        }
        else{
            $response = [
                'success' => false,
                'message' => "Unauthorized Access Denied"
            ];
        }
        return response()->json($response);
    }
}
