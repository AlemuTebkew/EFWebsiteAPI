<?php

namespace App\Http\Controllers;

use App\Models\RequestedService;
use App\Models\Service;
use App\Traits\ImageUpload;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    use ImageUpload;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Service::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $photo=null;
            $icon=null;
            if($request->photo)
            $photo = $this->uploadImage($request->photo);
            if($request->icon)
             $icon = $this->uploadImage($request->icon);
            return Service::create([...$request->all(), 'photo' => $photo , 'icon' => $icon]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function show(Service $service)
    {
        return response()->json($service, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Service $service)
    {
        try {
            $service->update($request->all());
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function destroy(Service $service)
    {
        RequestedService::where('service_id',$service->id)->delete();
        $this->unlinkImage($service->photo);
        $this->unlinkImage($service->logo);
        $service->delete();
    }


    public function updatePhoto(Request $request, $id)
    {

        $all = [];

        $service = Service::find($id);

        if($request->photo){
        $photo = $this->uploadImage($request->photo);
        $this->unlinkImage($service->photo);
        $service->photo = $photo;
        $service->save();
        return response()->json($service->photo, 200);

        }

        if($request->icon){
            $icon = $this->uploadImage($request->icon);
            $this->unlinkImage($service->icon);
            $service->icon = $icon;
            $service->save();
        }


    }
    public function updateLogo(Request $request, $id)
    {


        $logo = $this->uploadImage($request->logo);

        $service = Service::find($id);
        $this->unlinkImage($service->logo);
        $service->logo = $logo;
        $service->save();
        return response()->json($service->logo, 200);
    }
}
