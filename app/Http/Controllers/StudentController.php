<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\student;
use App\Models\attendance;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */



     
    public function student($selectedClass){
        

        $students = student::get()->where('class', '=', $selectedClass);
        
        $count = $students->count();
        if($count == 0){
            return response()->json(['Message'=> 'Student not found']);
        }
        return response()->json(['students' => $students, 'count' => $count, 'status'=>200 ]);
    }


    function submitAttendance(Request $request){
        $a = $request->attendance;

        $checkDay = attendance::where([['date', $request->today], ['sid', $a[0]['id']]])->exists();
        if($checkDay){
            return response()->json(['message'=> 'Already attendance exists', 'status'=> 403]);
        }

        foreach($a as $student){
            $save = new attendance;
            $save->sid = $student['id'];
            $save->attendance = $student['status'];
            $save->date = $request->today;
            $save->save();
            // $b[] = $student['status'];
        
            }
            return response()->json(['message' => 'Attendance added successfully', 'status'=>200 ]);
    }







}
