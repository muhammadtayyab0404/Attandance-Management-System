<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{

public function usertask(){

return $this->belongsTo(UserTask::class,'task_id','id');
}

//
}
