<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectPhoto extends Model
{
    use HasFactory;
    public $fillable=['path','project_id'];

    protected function path(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => file_exists(public_path().'/images/'.$value)? asset('images/'.$value) :null ,
        );
    }
}
