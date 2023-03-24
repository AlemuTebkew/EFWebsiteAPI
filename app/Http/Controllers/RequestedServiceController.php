<?php

namespace App\Http\Controllers;

use App\Models\RequestedService;
use App\Models\User;
use App\Notifications\UserNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Notification;

class RequestedServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function get_contacts()
    {
        auth()->user()->unreadNotifications->filter(function ($item) {
            return $item->data['type'] == 'service';
        })->markAsRead();
        return RequestedService::with('service')->latest()->get();
    }
    public function index()
    {
        return RequestedService::with('service')->latest()->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $data=[

            'title'=>'New Service Request',
            'message'=>$request->message.substr(0,50),
            'time'=>new Date(),
            'type'=>'service'

        ];
        Notification::send(User::all(), new UserNotification($data));


      return  RequestedService::create($request->all());


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\RequestedService  $requestedService
     * @return \Illuminate\Http\Response
     */
    public function show(RequestedService $requestedService)
    {
       return $requestedService;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\RequestedService  $requestedService
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RequestedService $requestedService)
    {
        $requestedService->update($request->all());
        return $requestedService;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RequestedService  $requestedService
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       $requestedService= RequestedService::find($id);
        $requestedService->delete();
        return response()->json('succcess',200);
    }
}
