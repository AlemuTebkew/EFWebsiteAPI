<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Experiance extends Model
{
    use HasFactory;
    public $fillable=['title','company','start_date','end_date','location','is_current','description','applicant_id'];

}
