<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AuthController extends Controller
{
     public function register(Request $request)
    {
        $validate = $request->validate([
            'name'  => 'required',
            'email' => 'required|email',
            'password'  => 'required',
            'password_confirmation' => 'required|same:password'
        ]);

        $validate['password'] = bcrypt($request->password);

        $user = User::create($validate);
        $success['token'] = $user->createToken('MDPApp')->plainTextToken;
        $success['name'] = $user->name;

        return response()->json($success, 200);
    }

    public function login(Request $request) {
        if(Auth::attempt([
            'email' => $request->email,
            'password' => $request->password
        ])) {
           $user = Auth::user(); // ambil data user dari tabel users sesuai dengan email dan pass
            if($user->role == 'admin'){
                $success['token'] = $user->createToken('MDPApp', ['create', 'read', 'update', 'delete'])->plainTextToken; // buat token
            } else {
                $success['token'] = $user->createToken('MDPApp', ['read'])->plainTextToken; // buat token
            }

            $success['name'] = $user->name; // response nama user
            return response()->json($success, 201); 
        } else {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }
}