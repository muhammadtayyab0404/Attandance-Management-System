<?php

namespace App\Models;
use App\Models\Task;

use Illuminate\Database\Eloquent\Model;

class UserTask extends Model
{

protected $fillable = ['user_id','task_id','status','taskans','document'];
   public function task(){
    return $this->belongsTo(Task::class,'task_id','id');
   }
   public function user(){
      return $this->belongsTo( User::class, 'user_id','id');
   }
}
