<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth:api', ['except' => ['login']]);
    // }

    public function create(Request $request)
    {
       //dd($request->all());

        $valid=Validator::make($request->all(),[
            'email'=>'required',
            'password'=>'required',
        ]);

        if($valid->fails())
        {
            return response()->json($valid->errors(),401);

        }
        else
        {
            try
            {
                $user=new User();
                $user->email = $request->email;
                $user->password = Hash::make($request->password);
                $usercreated=$user->save();

                if($usercreated)
                {

                    return response()->json(['msg'=>'user created','data'=>$user],200);

                }
                else
                {
                    return response()->json(['msg'=>'error','data'=>null],400);

                }

            }catch(Exception $e)
            {
                return response()->json(['msg'=>$e->getMessage()],400);
            }
        }
    }

    public function login(Request $request)
    {
        $valid=Validator::make($request->all(),[
            'email'=>'required',
            'password'=>'required',
        ]);

        if($valid->fails())
        {
            return response()->json($valid->errors(),401);

        }else{

            if (! $token = Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }

            return $this->respondWithToken($token);
            }
        }
}
