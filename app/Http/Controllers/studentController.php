<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class studentController extends Controller
{

    public function create(Request $request)
    {
       //dd($request->all());

        $valid=Validator::make($request->all(),[
            'name'=>'required',
            'email'=>'required',
            'department'=>'required',
            'age'=>'required',
        ]);

        if($valid->fails())
        {
            return response()->json($valid->errors(),401);

        }
        else
        {
            try
            {
                $user=new Student();
                $user->name = $request->name;
                $user->age = $request->age;

                $user->email = $request->email;
                $user->department = $request->department;

//                $user->password = Hash::make($request->password);
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

}
