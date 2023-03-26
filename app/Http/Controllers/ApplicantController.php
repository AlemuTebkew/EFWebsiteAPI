<?php

namespace App\Http\Controllers;

use App\Models\Applicant;
use App\Models\Certificate;
use App\Models\Education;
use App\Models\Experiance;
use App\Models\User;
use App\Notifications\ThanksNotification;
use App\Notifications\UserNotification;
use Illuminate\Support\Facades\Notification;

use App\Traits\ImageUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;

class ApplicantController extends Controller
{
    use ImageUpload;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {


        return Applicant::with('job')->latest()->get();
    }

    public function get_applicant()
    {

        auth()->user()->unreadNotifications->filter(function ($item) {
            return $item->data['type'] == 'job';
        })->markAsRead();
        return Applicant::with('job')->latest()->get();
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



            DB::beginTransaction();

            // $ex = Applicant::where('email', $request->email)->where('job_id', $request->job_id)->first();
            // if ($ex) {
            //     return response()->json('Duplicate Application Not Allowed', 400);
            // }
            $education = $request->education;
            $experiance = $request->experience;
            $certificate = $request->certificate;
            $applicant = $request->all();
            $applicant['cv'] = $this->uploadFile($request->cv);
            $applicant['supporting_doc'] = $this->uploadFile($request->supporting_doc);

            $new_applicant = Applicant::create($applicant);


            foreach ($education as $edu) {
                $edu = json_decode($edu, true);

                $edu['applicant_id'] = $new_applicant->id;
                Education::create($edu);
            }
            foreach ($experiance as $exp) {
                $exp = json_decode($exp, true);

                $exp['applicant_id'] = $new_applicant->id;
                Experiance::create($exp);
            }
            foreach ($certificate as $ce) {
                $ce = json_decode($ce, true);

                $ce['applicant_id'] = $new_applicant->id;
                Certificate::create($ce);
            }


            DB::commit();

            $data = [

                'title' => 'New Job Applied',
                'message' => $request->message . substr(0, 50),
                'time' => new Date(),
                'type' => 'job'

            ];
            Notification::send(User::all(), new UserNotification($data));
            Notification::route('mail', $request->email)->notify(new ThanksNotification());

            return $new_applicant;
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Applicant  $applicant
     * @return \Illuminate\Http\Response
     */
    public function show(Applicant $applicant)
    {
        return $applicant->load('experiances', 'educations', 'certificates', 'job');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Applicant  $applicant
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Applicant $applicant)
    {
        try {
            $applicant->update($request->all());
            return $applicant;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Applicant  $applicant
     * @return \Illuminate\Http\Response
     */
    public function destroy(Applicant $applicant)
    {
        $this->unlinkImage($applicant->cv);
        $this->unlinkImage($applicant->supporting_doc);

        $applicant->certificates()->delete();
        $applicant->educations()->delete();
        $applicant->experiances()->delete();
        $applicant->delete();
    }
}
