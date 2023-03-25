<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Traits\ImageUpload;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    use ImageUpload;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Team::all();
    }
    public function get_teams()
    {
        return Team::where('is_active', 1)->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request->all();
        $photo = null;
        try {
            if ($request->photo) {
                $photo = $this->uploadImage($request->photo);
            }

            return $photo ?  Team::create([...$request->all(), 'photo' => $photo])
                : Team::create([...$request->all()]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function show(Team $team)
    {
        return response()->json($team, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Team $team)
    {

        $photo = null;
        try {

            if ($request->photo) {
                $photo = $this->uploadImage($request->photo);
            }

            $photo ?  $team->update([...$request->all(), 'photo' => $photo])
                : $team->update($request->all());

            return $team;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function destroy(Team $team)
    {
        $team->delete();
    }
}
