<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestedService extends Model
{
    use HasFactory;
    public $fillable=['name','email','phone_no','address','message','service_id'];

    public function service(){
        return $this->belongsTo(Service::class);
    }
}
