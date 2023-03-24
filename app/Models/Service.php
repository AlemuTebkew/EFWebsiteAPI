<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;
    public $fillable=['title','icon','photo','description','short_desc'];

    protected function photo(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => file_exists(public_path().'/images/'.$value)? asset('images/'.$value) :null ,
        );
    }
    protected function icon(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => file_exists(public_path().'/images/'.$value)? asset('images/'.$value) :null ,
        );
    }
}
