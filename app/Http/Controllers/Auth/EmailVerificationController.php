<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Manager;
use App\Traits\ApiMessage;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
class EmailVerificationController extends Controller
{
    use ApiMessage;
    public function sendVerificationEmail(Request $request){

        if ($request->user()->hasVerifiedEmail()) {
            return $this->sendError('Already Verified','');

        }

        $request->user()->sendEmailVerificationNotification();

        return $this->sendResponse('Verfication link sent','');
    }

    public function verify(Request $request)
    {
        if (!$request->hasValidSignature(true)) {
            return response()->json(["msg" => "Invalid/Expired url provided."], 401);
        }

        //  return $request->route('id');
        $user= Manager::find($request->id);

        if(! $user){
            return response()->json(["msg" => "no id provided."], 401);

        }
        if (! hash_equals((string) $request->id, (string) $user->getKey())) {
            throw new  AuthorizationException;
        }

        if (! hash_equals((string) $request->hash, sha1($user->getEmailForVerification()))) {
            throw new AuthorizationException;
        }


        if ($user->hasVerifiedEmail()) {

            if($user->type='system_user'){
                return redirect(url(env('FRONTEND_MANAGER_URL').'/login'));

            }else if(($user->type='agent')){
                return redirect(url(env('FRONTEND_AGENT_URL')).'/agent_login');

            }

            // return $this->sendError('Already Verified','');

        }

        // if ($request->user()->markEmailAsVerified()) {
        //     event(new Verified($request->user()));
        // }

        // return $this->sendResponse('Email has been verified','');

        //  $user=Admin::findOrFail(request('id'));

          if ($user->markEmailAsVerified()) {

            //  $user->markEmailAsVerified();
             event(new Verified($user));

           // return  response()->json('verified',200) ;
                    //  return redirect(url(env('FRONTEND_URL')).'/login');
        }
        if($user->type='system_user'){
            return redirect(url(env('FRONTEND_MANAGER_URL').'/login'));

        }else if(($user->type='agent')){
            return redirect(url(env('FRONTEND_AGENT_URL').'/agent_login'));

        }

    }

    public function resend(Request $request){
      //  $user=null;

        $request->user()->sendEmailVerificationNotification();

        return $this->sendResponse('Verfication link sent','');
    }
}
