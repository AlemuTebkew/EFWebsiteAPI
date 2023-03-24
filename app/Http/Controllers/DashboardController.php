<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Project;
use App\Models\Team;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $client = Client::count();
        $team = Team::count();
        $c_project = Project::where('is_completed', 1)->count();
        $o_project = Project::where('is_completed', 0)->count();
        $projects = Project::where('is_completed', 0)->select('title','progress')->latest()->take(10)->get();

        return [
            'client' => $client,
            'team' => $team,
            'c_project' => $c_project,
            'o_project' => $o_project,
            'projects' => $projects,
            'notifications'=>auth()->user()->unreadNotifications
        ];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function read()
    {
        $type=request('type');

        if($type){
               auth()->user()->unreadNotifications->filter(function($item) use($type){
            return $item->data['type'] == $type;
         })->markAsRead();
        }else {
            auth()->user()->unreadNotifications->markAsRead();
        }

         return response()->json('success',200);
    }
}
