<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Applicant extends Model
{
    use HasFactory;
    public $fillable = [
        'f_name',
        'm_name',
        'l_name',
        'phone_no',
        'email',
        'bio',
        'photo',
        'city',
        'sub_city',
        'woreda',
        'cv',
        'supporting_doc',
        'job_id'
    ];

    protected function cv(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => file_exists(public_path().'/docs/'.$value)? asset('docs/'.$value) :null ,
        );
    }

    protected function supportingDoc(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => file_exists(public_path().'/docs/'.$value)? asset('docs/'.$value) :null ,
        );
    }
    public function certificates(){
        return $this->hasMany(Certificate::class);
    }
    public function educations(){
        return $this->hasMany(Education::class);
    }
    public function experiances(){
        return $this->hasMany(Experiance::class);
    }
    public function job(){
        return $this->belongsTo(Job::class);
    }
}
