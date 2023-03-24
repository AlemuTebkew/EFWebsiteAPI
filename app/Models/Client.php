<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;
    public $fillable=['title','category','logo'];

    protected function logo(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => file_exists(public_path().'/images/'.$value)? asset('images/'.$value) :null ,
        );
    }
}
