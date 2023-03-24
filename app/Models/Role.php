<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    public $fillable=['title'];

    public function permissions(){
        return $this->belongsToMany(Permission::class,'permission_roles');
    }

    public function user(){
        return $this->hasOne(User::class);
    }
}
