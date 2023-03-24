<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ProjectPhoto;
use App\Traits\ImageUpload;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    use ImageUpload;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Project::with('photos')->latest()->get();
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
        try {

            $project= Project::create([...$request->all(),'is_completed'=>($request->progress == 100)? 1:0]);

            foreach ($request->photos as $photo) {
            $photo = $this->uploadImage($photo);

            ProjectPhoto::create([
                'path'=>$photo,
                'project_id'=>$project->id
            ]);

            }
          return response()->json($project->load('photos') ,201);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        return response()->json($project->load('photos'),200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Project $project)
    {
        try {
            $project->update($request->all());
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        foreach ($project->photos as $p) {
            $this->unlinkImage($p->path);
            }
        $project->photos()->delete();
        $project->delete();
    }

    public function updatePhoto(Request $request, $id)
    {

        $all = [];
        foreach ($request->photos as $photo) {

            $photo = $this->uploadImage($photo);

            $photo = ProjectPhoto::create([
                'path' => $photo,
                'project_id' => $id
            ]);
            $all[] = $photo;
        }

        return response()->json($all, 200);
    }

    public function deletePhoto($id)
    {
        $photo = ProjectPhoto::find($id);

        if ($photo) {
            $this->unlinkImage($photo->path);
            $photo->delete();
        }

        return response()->json('success', 200);

    }
}
