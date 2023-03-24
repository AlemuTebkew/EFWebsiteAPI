<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;
    public $fillable=['title','photo','tags','posted_by','description','short_desc'];

    public function photos(){
        return $this->hasMany(NewsPhoto::class);
    }
}
