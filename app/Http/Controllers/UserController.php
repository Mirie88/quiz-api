<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    public function index()
{
    return User::all();
}

    public function store(Request $request)
    {
        try {

             

            $validatedfields = $request->validate([
                'name' =>'required|string|max:255',
                'email' =>'required|email|unique:users',
                'password'=>'required|regex:/[a-z]/|regex:/[A-Z]/|regex:/[0-9]/|regex:/[!@#$%^&*()_<>?:]/',
            
            ],
        [
            'password.regex' => 'Password must contain uppercase, lowercase, numeric and special characters',
            // 'email.unique' => 'This email has already been taken',
        ]);
        $validatedfields["role"] = "user";

       $user = User::create($validatedfields);
       
       return response()->json([
        'message' => 'user created successfully!!'
       ]);


        } catch (\Illuminate\Validation\ValidationException $e) {
            
            return response()->json([
                'errors' => $e->errors(),
            ]);

            $token = JWTAuth::fromUser($user);

        return response()->json(compact('user','token'), 201);
        }

        
    }

    public function login(Request $request)
    {
        $details = $request->only('email', 'password');

        try {
            if (! $token = JWTAuth::attempt($details)) {
                return response()->json(['error' => 'Invalid credentials'], 401);
            }

            // Get the authenticated user.
            $user = auth()->user();

            // (optional) Attach the role to the token.
            $token = JWTAuth::claims(['role' => $user->role])->fromUser($user);

            return response()->json(compact('token'));
        } catch (JWTException $e) {
            return response()->json(['error' => 'Could not create token'], 500);
        }
    }

    // Get authenticated user
    public function getUser()
    {
        try {
            if (! $user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['error' => 'User not found'], 404);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'Invalid token'], 400);
        }

        return response()->json(compact('user'));
    }

    // User logout
    public function logout()
    {
        JWTAuth::invalidate(JWTAuth::getToken());

        return response()->json(['message' => 'Successfully logged out']);
    }

    public function update(Request $request)
    {
        $user = User::find($request->id);
        if(!$user->role === 'admin')
        {
            return response()->json([
             'message' =>'Unauthorized'
            ],403);
        }
try {
    $request->validate([
        'name' => 'sometimes|string|max:255',
        'email' => 'sometimes|email|max:255|unique:users,email,',
        'password' => 'sometimes|regex:/[a-z]/|regex:/[A-Z]/|regex:/[0-9]/|regex:/[!@#$%^&*()_<>?:]/|min:8',
        'role' => 'sometimes|in:admin,user'
        
    ]);

    $user->update([
     'name' => $request->name ?? $user->name,
     'email' => $request->email ?? $user->email,
     'password' => $request->password ?? $user->password,
     'role' => $request->role ?? $user->role,
    ]);
    return response()->json($user);
}
 catch (\Exception $e) {
    return response()->json([
        "Error" => $e->getMessage()
    ]);
}
     
    }
} 
