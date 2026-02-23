<?php

namespace App\Http\Controllers;

use App\Models\Leave;
use App\Models\Profile;
use App\Models\Task;
use App\Models\User;
use App\Services\WhatsAppService;
use App\Services\MetaWhatsapppService;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use App\Models\Attendence;
use App\Models\UserTask;
use Carbon\Carbon;

class Attendance extends Controller
{

public function dashboardstats(){
    $userid = auth()->id();
    $today= Carbon::today();
    $todaydate = date('Y-m-d');
    $displaydate= date('l, d F Y');

    $isSunday = $today->isSunday();

    $exists = Attendence::where('prof_id', $userid)
    ->where('date', $todaydate)
    ->first();

    return view('dashboard', compact('exists' ,'todaydate','displaydate','isSunday'));
}

   public function newattendance(Request $request){

   $credential = $request->validate([
    'todaydate'=> 'required|date', 
    ]);

    $newdate = date('Y-m-d', strtotime($request->todaydate));

    $userid = auth()->id();

    $exists = Attendence::where('prof_id', $userid)
    ->where('date', $newdate)
    ->exists();
    
    if($exists){
        return back()->with('error', 'You have already marked your attendance today ❌');
    }


       
   $usersphone = User::where('is_admin' , 1)->get();

   

   foreach($usersphone as $phone){
    $formattedPhone = $phone->phone;

    $whatsapp = new MetaWhatsapppService();
    $whatsapp->metasendMessage($formattedPhone,  "Your attendance has been successfully marked.");
   }
    

    $attend = new Attendence();
    $attend->date= $newdate;
    $attend->mark=true;
    $attend->prof_id= auth()->id();
    $attend->save();



    return back()->with('success', 'Attendance marked successfully ✅');


   } 

   public function studentstats(){

   $userid = auth()->id();

   $alldata = Attendence::where('prof_id',$userid)
   ->get(['id','date','mark'])
   ->keyBy('date');

   $startdate = Carbon::create(2026,2,1);

   $lastAttendanceDate = $alldata->max('date');
   $enddate = $lastAttendanceDate ? Carbon::parse($lastAttendanceDate) : Carbon::today();

   $period = CarbonPeriod::create($startdate,$enddate);

   $attendance = [];
   $present = 0;
   $absent = 0;
   $leave = 0;
   $totalclasses = 0; 

   foreach ($period as $date) {

        
        if ($date->isSunday()) {
            continue;
        }

        $totalclasses++;

        $formattedDate = $date->format('Y-m-d');

        if(isset($alldata[$formattedDate]) && $alldata[$formattedDate]->mark == 1){
            $status = 'Present';
            $present++;
            $rowid = $alldata[$formattedDate]->id;

        }elseif (isset($alldata[$formattedDate]) && $alldata[$formattedDate]->mark == 0){
            $status = 'Leave';
            $leave++;
            $rowid = $alldata[$formattedDate]->id;
        }
        else{
            $status = 'Absent';
            $absent++;
            $rowid = null;
        }

        $attendance[] = [
            'date' => $formattedDate,
            'status' => $status,
            'id' => $rowid,
        ];
   }

   
   $percentage = $totalclasses > 0 ? ($present / $totalclasses) * 100 : 0;

   $attendance = collect($attendance)->reverse()->values();
   $percent = intval($percentage);

   return view('student.record', [
        'alldata' => $attendance,
        'totalattendance' => $totalclasses,
        'present' => $present,
        'absent' => $absent,
        'percent' => $percent,
        'leave' => $leave
   ]);
}
   public function showleave(){

   $todaydate = Carbon::today()->format('Y-m-d');

   $alldata = Leave::where('user_id', auth()->id())
   ->get() ;

    return view('student.leaverequest',compact('alldata','todaydate' )) ;
   }

   public function leaverequest(Request $request){

   $credentials = $request->validate([
    'startdate' =>'required|date',
    'enddate' =>'required|date',
    'reason' =>'nullable'] );
   
    $userid = auth()->id();

    $attend = new Leave();
    $attend->status ='pending';
    $attend->reason =$credentials['reason'];
    $attend->start_date =$credentials['startdate'];
    $attend->end_date =$credentials['enddate'];
    $attend->user_id =$userid;

    $attend->save();

    return redirect()->back()->with('success', 'Form submitted successfully!');


   }

   public function studenttask(){

   $usrid = auth()->id();

   $alltask= Task::all();

   $submittedtask =UserTask::where('user_id' , $usrid ) 
        ->get()
        ->keyBy('task_id'); ;


    return view('student.studenttask',compact('alltask', 'submittedtask'));
   }

   public function studenttaskshow(Request $request, $id){
   
   $data = Task::where('id',$id)->first();
   
   return view('student.showtask',compact('data'));
   
   }

   public function showprofile(){
   
   $user =auth()->user();
   $userid = $user->id;       // get the user by id

   $profilepic=Profile::where('prof_id',$userid )->first();

    return view('student.showprofile',compact('user','profilepic'));
   }

   public function updateprofile(Request $request){

   $credentials= $request->validate([
            'name' => 'required|string|max:255',
            'age' => 'required',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            ]);


       $photoPath = null;

     if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('photos', 'public');
        }
        $user= auth()->user();
        $user->name = $credentials['name'];
        $user->age  = $credentials['age'];

          
         if ($photoPath)
             {
                $user->profile()->updateOrCreate(
                    ['prof_id' => $user->id],
                    ['photo' => $photoPath]
                    );
             }
     $user->save(); // save changes

    return redirect()->back()->with('success', 'Profile updated successfully!');
}

public function submitTask(Request $request , $id){

$formdata= $request->validate([
    'taskans' => 'required',
    'document' => 'nullable|file|mimes:pdf,doc,docx,txt',
]);

$taskans= $formdata['taskans'];
$usrid = auth()->id();
  $photoPath = null;

  if ($request->hasFile('document')) {
            $photoPath = $request->file('document')->store('document', 'public');
        }

       UserTask::create([
        'task_id' => $id,
        'user_id' => $usrid,
         'status' => 'Pending',
         'taskans' => $taskans,
         'document'=>$photoPath
       ]);

return redirect()->route('studenttask');
}

}
