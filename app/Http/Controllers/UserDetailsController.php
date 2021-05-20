<?php


namespace App\Http\Controllers;


use App\Models\User_details;

class UserDetailsController extends Controller
{
    public function store(Request $request){
        try {
            $user = new User_details();
            $user -> maritalStatus = $request->maritalStatus;
            $user->occupation = $request->occupation;

            if ($user->save()){
                return response()->json(['status'=>'success', 'message'=>'Post created successfully']);
            }
        }catch (Exception $exception){
            return response()->json(['status'=>'error', 'message'=>$exception->getMessage()]);
        }
    }


}
