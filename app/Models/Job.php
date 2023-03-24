<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;
    public $fillable=['title','description','type','is_active','deadline','posted_by','department_id','required_amount','sex'];

    public function user(){
        return $this->belongsTo(User::class,'posted_by');
    }
}
