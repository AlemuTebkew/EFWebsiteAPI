<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    use HasFactory;
    public $fillable=['title','is_completed','description','short_desc','progress','category_id'];

    public function photos(){
        return $this->hasMany(ProjectPhoto::class);
    }
}
