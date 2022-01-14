<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

use App\Http\Requests\LoginRequest;

class UserController extends Controller
{

    public function data(Request $request)
    {
        return response()->json(
           
           
            [['title'=>'ux designer','id'=>1,'details'=>'lorem'],
            ['title'=>'uxa designer','id'=>2,'details'=>'lorem'],
            ['title'=>'uxb designer','id'=>3,'details'=>'lorem'],
            ['title'=>'uxc designer','id'=>4,'details'=>'lorem']],
            
            200);
            
            
    }


    public function create(Request $request)
    {
       //dd($request->all());

        $valid=Validator::make($request->all(),[
            'email'=>'required',
            'password'=>'required',
        ]);

        if($valid->fails())
        {
            return response()->json($valid->errors(),422);

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

    public function login(LoginRequest $request)
    {
        if (! $token = Auth::guard('api')->attempt(['email' => $request->email, 'password' => $request->password])) {
            return response()->json(['message' => 'your password or email is incorrect.','status'=> false], 422);
        }
        return $this->respondWithToken($token);        
    }
}
