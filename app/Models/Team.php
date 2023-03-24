<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;
    public $fillable = [
        'f_name',
        'm_name',
        'l_name',
        'phone_no',
        'email',
        'empId',
        'photo',
        'department_id',
        'address',
        'gender',
        'dob',
        'is_active',
        'profession',
        'quote'
    ];

        //getter and setters
        protected function photo(): Attribute
        {
            return Attribute::make(
                get: fn ($value) => file_exists(public_path().'/images/'.$value)? asset('images/'.$value) :null ,
            );
        }
}
