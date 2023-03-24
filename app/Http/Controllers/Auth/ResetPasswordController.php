<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Admin;
use App\Models\Manager;
use App\Models\User;
use App\Notifications\SuccessEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ResetPasswordController extends Controller
{
    public function resetPassword(Request $request,$token){
            //Validate input
            $validator = Validator::make($request->all(), [
               // 'email' => 'required|email|exists:admins,email',
                'password' => 'required',
               // 'token' => 'required'
            ]);

            //check if payload is valid before moving on
            if ($validator->fails()) {
                return response()->json(['email' => 'Please complete the form']);
            }

            $password = $request->password;
        // Validate the token
            $tokenData = DB::table('password_resets')->where('token', $token)->first();
        // Redirect the user back to the password reset request form if the token is invalid
        // $time_to_expire= \Carbon\Carbon::createFromFormat('Y-m-d H:i:s',\Carbon\Carbon::now() )->diffInMinutes($tokenData->created_at);

        // if($time_to_expire > 5){
        //     return response()->json('expired token',401);

        // }
          if (!$tokenData)
            return response()->json('not valid token',401);

            $user = User::where('email', $tokenData->email)->first();
        // Redirect the user back if the email is invalid
            if (!$user)
            return response()->json('not valid user',401);
            //Hash and update the new password
            $user->password = Hash::make($password);
            $user->update(); //or $user->save();

            //login the user immediately they change password successfully
            //Auth::login($user);

            //Delete the token
            DB::table('password_resets')->where('email', $user->email)
            ->delete();

            //Send Email Reset Success Email
            // if ($this->sendSuccessEmail($tokenData->email)) {

                 $token=$user->createToken('auth_token')->plainTextToken;
                return response()->json([
                    'access_token'=>$token,
                   'user'=>$user,
                ],200);
            //    // return response()->json('successfuly reset ur password',200);
            // } else {
            //     return response()->json('try again',401);
            // }


}
//   private function sendSuccessEmail($email){

//      try {
//         $user = Admin::where('email', $email)->first();
//         $user->notify(new SuccessEmail());
//         return true;

//      } catch (\Throwable $th) {
//         return false;
//      }
//   }
}
