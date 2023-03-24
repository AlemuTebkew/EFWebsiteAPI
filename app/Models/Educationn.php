<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    use HasFactory;
    public $fillable=['company','study_field','degree_type','end_date','start_date','cgpa','applicant_id','description'];

}
