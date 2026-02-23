<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendence extends Model
{
    
    protected $fillable =['prof_id','date','mark'];

        public function users(){
        return $this->belongsTo(User::class,'prof_id' , 'id');
    }
}
