<?php

namespace App\Models;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Leave extends Model
{
    protected $fillable =['status'];

    public function users(){
        return $this->belongsTo(User::class,'user_id' , 'id');
    }
}
