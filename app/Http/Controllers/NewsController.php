<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\NewsPhoto;
use App\Models\ProjectPhoto;
use Illuminate\Http\Request;
use App\Traits\ImageUpload;

class NewsController extends Controller
{
    use ImageUpload;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return News::with('photos')->latest()->get();
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
            // $photo = $this->uploadImage($request->photo);
            $news = News::create([...$request->all()]);

            foreach ($request->photos as $photo) {
                $photo = $this->uploadImage($photo);

                NewsPhoto::create([
                    'path' => $photo,
                    'news_id' => $news->id
                ]);
            }
            return response()->json($news->load('photos'), 201);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\News  $news
     * @return \Illuminate\Http\Response
     */
    public function show(News $news)
    {
        return response()->json($news->load('photos'), 200);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\News  $news
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, News $news)
    {
        try {

            $news->update([...$request->all()]);
            return response()->json($news, 200);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\News  $news
     * @return \Illuminate\Http\Response
     */
    public function destroy(News $news)
    {
        try {
            foreach ($news->photos as $p) {
            $this->unlinkImage($p->path);
            }
            $news->photos()->delete();
            $news->delete();
            return response()->json('success', 200);

        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function updatePhoto(Request $request, $id)
    {

        $all = [];
        foreach ($request->photos as $photo) {

            $photo = $this->uploadImage($photo);

            $photo = NewsPhoto::create([
                'path' => $photo,
                'news_id' => $id
            ]);
            $all[] = $photo;
        }

        return response()->json($all, 200);
    }
    public function deletePhoto($id)
    {
        $photo = NewsPhoto::find($id);

        if ($photo) {
            $this->unlinkImage($photo->path);
            $photo->delete();
        }

        return response()->json('success', 200);

    }
}
