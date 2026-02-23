<?php

namespace App\Http\Controllers;

use App\Models\Attendence;
use App\Models\Leave;
use App\Models\Profile;
use App\Models\Task;
use App\Models\User;
use App\Models\UserTask;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;


class AdminController extends Controller
{
 public function admindashboardstats(){

 $users =User::where('is_admin', '!=', 1)->get();

 return view('Admin.dashboard',compact('users'));
 }

 public function stuAttend(){
 $users =User::where('is_admin', '!=', 1)->get();

 return view('Admin.attendance',compact('users'));
 }

 public function stuShowatten(Request $request, $id){


$alldata = Attendence::where('prof_id',$id)
   ->get(['id','date','mark'])
   ->keyBy('date');
 
   

   $startdate = Carbon::create(2026,2,1);

 $lastAttendanceDate = $alldata->max('date'); // max date from DB
$enddate = $lastAttendanceDate ? Carbon::parse($lastAttendanceDate) : Carbon::today();


   $period =CarbonPeriod::create($startdate,$enddate);
   $totalclasses = count($period);

   $attendance = [];
   $present=0;
   $absent=0;
   $leave=0;


   foreach ($period as  $date) {
        $formattedDate = $date->format('Y-m-d');

          if ($date->isSunday()) {
            continue;
        }
       
  
        if(isset($alldata[$formattedDate]) && $alldata[$formattedDate]->mark == 1){
            $status ='Present';
            $present++;
            $rowid = $alldata[$formattedDate]->id;

        }elseif (isset($alldata[$formattedDate]) && $alldata[$formattedDate]->mark ==0){
            $status ='Leave';
            $leave++;
            $rowid = $alldata[$formattedDate]->id;
        }
        
        else{
            $status ='Absent';
            $absent++;
            $rowid = null;
        }

    $attendance [] =[
        'date' =>$formattedDate,
        'status' => $status,
        'id' => $rowid,
    ];
   }
   $percentage= ($present / $totalclasses) * 100;
   
   $percent=intval($percentage);

   $attendance = collect($attendance)->reverse()->values();

    return view('Admin.record' ,  ['alldata' =>$attendance , 'totalattendance' => $totalclasses,'present' =>$present, 'leave' =>$leave,'absent'=>$absent, 'percent' =>$percent, 'userid' =>$id ]);
   }


   public function deleteAttend(Request $request, $id){

   User::where('id',$id)->delete();
   return back();
   }

   public function removeAttend(Request $request, $id){
    Attendence::where('id', $id)->delete();
   return back();
   }

 public function updateattend(Request $request, $id){
    $formdate = $request->input('usrdate');

  Attendence::updateOrCreate([

     'prof_id' => $id ,
    'date'=> $formdate,
  ],
  [
    'mark'=> 1
    ]);
   
 
 return back();

   }

   public function adminleave(){
    
   $users=Leave::with('users')->get();
    return view('Admin.adminleave' ,compact('users'));
   }

   public function deleteLeave($id){
    
   Leave::where('id', $id)->delete();

   return  back();
   }

   public function showLeave(Request $request , $id){

   $leavedata= Leave::where('id',$id)->first(); 

   return view('Admin.adminleaveaction',compact('leavedata') );

   }

   public function adminLeavereq(Request $request, $id){

    $formdata = $request->validate([
        'status' => 'required|string',
        'admincomment' => 'nullable',
        'startdate' =>'required',
        'enddate' => 'required',
    ]);

   

    $status = $formdata['status'];
    $admincomment= $formdata['admincomment'];
    $startdate= $formdata['startdate'];
    $enddate= $formdata['enddate'];

     $leave = Leave::findOrFail($id);
    $leave->status = $status;
    $leave->comment = $admincomment;
    $leave->save();

    if($formdata['status'] == 'approved'){
       
    $period = CarbonPeriod::create($startdate,$enddate);

    foreach ($period as  $date) {
        $formateddate = $date->format('Y-m-d');

        Attendence::updateOrCreate(
                [
                    'prof_id' => $leave->user_id, 
                    'date' => $formateddate
                ],
                [
                    'mark' => 0 
                ]
            );
    }

 
    }


   return redirect()->route('adminleave');
   }



      public function showprofile(){
   
   $user =auth()->user();
   $userid = $user->id;       // get the user by id

   $profilepic=Profile::where('prof_id',$userid )->first();

    return view('Admin.showprofile',compact('user','profilepic'));
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
public function attenSummary()
{
      $records = Attendence::with('users')->get()->groupBy('prof_id');

    $startdate = Carbon::create(2026, 2, 1);

    $lastAttendanceDate = Attendence::max('date');
    $enddate = $lastAttendanceDate
    ? Carbon::parse($lastAttendanceDate)
    : Carbon::today();

    $rows = [];

          $present = 0;
        $absent = 0;
        $leave = 0;

    foreach ($records as $userId => $userRecords) {

        $userRecords = $userRecords->keyBy('date');
        $username = $userRecords->first()->users->name;

        $period = CarbonPeriod::create($startdate, $enddate);

        foreach ($period as $date) {

          if ($date->isSunday()) {
            continue;
        }

            $formattedDate = $date->format('Y-m-d');

            if (isset($userRecords[$formattedDate]) && $userRecords[$formattedDate]->mark == 1) {
                $status = 'Present';
                $present++;
            } elseif (isset($userRecords[$formattedDate]) && $userRecords[$formattedDate]->mark == 0) {
                $status = 'Leave';
                $leave++;
            } else {
                $status = 'Absent';
                $absent++;
            }

            $rows[] = [
                'date' => $formattedDate,
                'name' => $username,
                'day' => $date->format('l'),
                'status' => $status,
                'present' => $present,
                'absent' => $absent,
                'leave' => $leave,
            ];
        }
    }

    // Most recent first
    $rows = collect($rows)->sortByDesc('date')->values();


     $users = collect($rows)->groupBy('name');
                

    $newstart= Carbon::parse($startdate)->format('Y-m-d');
    return view('Admin.attensummary' ,  ['alldata' =>$rows,'startdate' =>$newstart, 'enddate' =>$enddate, 'users' => $users  ]);

 }
     
 public function selecteddates(Request $request){

       $records = $request->validate([
        'to' => 'date',
        'from' => 'date'
       ]);    
    $fromdate=$records['from'];
    $todate=$records['to'];


     $records = Attendence::with('users')
     ->whereBetween('date', [$fromdate, $todate])
     ->get()
     ->groupBy('prof_id');

    $startdate = Carbon::parse($fromdate);

    $enddate = Carbon::parse($todate);
        $present = 0;
        $absent = 0;
        $leave = 0;

    $rows = [];


    foreach ($records as $userId => $userRecords) {
        
    

        $userRecords = $userRecords->keyBy('date');
        $username = $userRecords->first()->users->name;

        $period = CarbonPeriod::create($startdate, $enddate);

        foreach ($period as $date) {

          if ($date->isSunday()) {
            continue;
        }

            $formattedDate = $date->format('Y-m-d');

            if (isset($userRecords[$formattedDate]) && $userRecords[$formattedDate]->mark == 1) {
                $status = 'Present';
                $present++;
            } elseif (isset($userRecords[$formattedDate]) && $userRecords[$formattedDate]->mark == 0) {
                $status = 'Leave';
                $leave ++;
            } else {
                $status = 'Absent';
                $absent ++;
            }

            $rows[] = [
                'date' => $formattedDate,
                'name' => $username,
                'day' => $date->format('l'),
                'status' => $status,
                'present' => $present,
                'absent' => $absent,
                'leave' => $leave,
                
            ];
        }
    }

    // Most recent first
    $rows = collect($rows)->sortByDesc('date')->values();


     $users = collect($rows)->groupBy('name');
                

    return view('Admin.datesummary' ,  ['alldata' =>$rows ,'users' => $users ]);

       }

   public function checkGrades(){

        $records = Attendence::with('users')->get()->groupBy('prof_id');

    $startdate = Carbon::create(2026, 2, 1);

    $lastAttendanceDate = Attendence::max('date');
    $enddate = $lastAttendanceDate
    ? Carbon::parse($lastAttendanceDate)
    : Carbon::today();

    $rows = [];


    foreach ($records as $userId => $userRecords) {

        $userRecords = $userRecords->keyBy('date');
        $username = $userRecords->first()->users->name;

        $period = CarbonPeriod::create($startdate, $enddate);


          $present = 0;
        $absent = 0;
        $leave = 0;

        foreach ($period as $date) {

            $formattedDate = $date->format('Y-m-d');

            if (isset($userRecords[$formattedDate]) && $userRecords[$formattedDate]->mark == 1) {
                $status = 'Present';
                $present++;
            } elseif (isset($userRecords[$formattedDate]) && $userRecords[$formattedDate]->mark == 0) {
                $status = 'Leave';
                $leave++;
            } else {
                $status = 'Absent';
                $absent++;
            }

            // $rows[] = [
            //     'date' => $formattedDate,
            //     'name' => $username,
            //     'day' => $date->format('l'),
            //     'status' => $status,
            //     'present' => $present,
            //     'absent' => $absent,
            //     'leave' => $leave,
            // ];
        }

           if ($present >= 26) {
            $grade = 'A';
        } elseif ($present >= 20) {
            $grade = 'B';
        } elseif ($present >= 15) {
            $grade = 'C';
        } elseif ($present >= 10) {
            $grade = 'D';
        } else {
            $grade = 'F';
        }

        
        $summary[] = [
            'user_id' => $userId,
            'name' => $username,
            'present' => $present,
            'absent' => $absent,
            'leave' => $leave,
            'grade' => $grade,
            
            ];

    }

    return view('Admin.gradeummary', [
        'alldata' => $summary,
        'startdate' => $startdate->format('Y-m-d'),
        'enddate' => $enddate->format('Y-m-d'),
    ]);
}

public function viewadmintask(){

$alltask= UserTask::with(['user', 'task'])->get();

    return view('Admin.admintask',compact('alltask'));
}
     

public function addtaskAdmin(){

    return view('Admin.addadmintask');
}
public function taskAdeed(Request $request){
    
    $data = $request->validate
    ([
    'title' => 'required|string|max:255',
    'description' => 'required|string',
    'deadline' => 'required|date',
   ]);

$title = $data['title'];
$descri =$data['description'];
$deadline=Carbon::parse( $data['deadline']);

$newtask = new Task();
$newtask->title =$title;
$newtask->description =$descri;
$newtask->deadline =$deadline;

$newtask->save();

return redirect()->route('viewadmintask')->withErrors('Success');
}

public function aprroveStatus(Request $request, $id){

UserTask::where('id' , $id)->update([
    'status' => 'Completed'
]);

return back();
}
public function rejectStatus(Request $request, $id){

    UserTask::where('id' , $id)->update([
    'status' => 'Rejected'
]);
return back();
}

public function viewuserTask(Request $request, $id,$tskid){
    
$tasks = UserTask::where('user_id', $id)
->with('task','user')
->where('task_id',$tskid)
->first();

return view('Admin.viewsubmittask' ,compact('tasks'));
}

public function updateusersTask(Request $request){

 $data = $request->validate([
    'usrid' =>'required',
    'tskid'=>'required',
    'status' => 'required|string',
    'feedback' => 'nullable',

 ]);

 $usrid =$data['usrid'];
 $tskid =$data['tskid'];
 $feedback =$data['feedback'];
 $status =$data['status'];


 UserTask::where('user_id',$usrid)
 ->where('task_id',$tskid)
 ->update([
    'feedback' =>$feedback,
    'status' =>$status

 ]);

    return back()->withErrors('success' , 'Status Updated Successfully ');
}

}
