<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\student;
use App\Models\attendance;
use Illuminate\Support\Facades\DB;

class AttendanceController extends Controller
{
    //
    function getStudent(Request $request){
        $class = $request->selectedClass;
        $month = $request->selectedMonth;
        $student = student::where('class', $class)->get();

        $attendance = attendance::where('class_id', $class)->orderBy('date')->where('date', 'LIKE', "%{$month}%")
        ->get()
        ->groupBy('roll');

        return response()->json(['attendance'=>$attendance, 'students'=>$student]);
    }




    function checkAttendance(Request $request){
        $class = $request->selectedClass;
        $roll = $request->roll;
        $fromDate = $request->fromDate;
        $toDate = $request->toDate;

        $student = student::where('class', $class)->where('rollno', $roll)->get();

        $attendance = attendance::where('class_id', $class)
        ->whereBetween('date', [$fromDate, $toDate])
        ->orderBy('date')
        ->get()
        ->groupBy('roll');


        return response()->json(['attendance'=>$attendance, 'students'=>$student]);
    }


    function lastDayAbsenca(Request $request){
        // $today = '2022-06-25';
        $today = $request->today;
        $class = $request->selectedClass;

        $yesterday= date("Y-m-d", strtotime($today.'-1 days' ) );

        $checkHoliday = attendance::where('date', $yesterday)->exists();

        if(!$checkHoliday){
            for($i=-1; !$checkHoliday; $i--){
                $yesterday= date("Y-m-d", strtotime($today.$i.' days' ) );
                $checkHoliday = attendance::where('date', $yesterday)->exists();        
            }
            $lastAbsence = attendance::where('date', $yesterday)
            ->where('class_id', $class)
            ->where('attendance', 'absent')
            ->get();
            return response()->json(['lastAbsence'=>$lastAbsence, 'message'=>"Not yesterDay"]);
        }

        $lastAbsence = attendance::where('date', $yesterday)
        ->where('class_id', $class)
        ->where('attendance', 'absent')
        ->get();


        return response()->json(['lastAbsence'=>$lastAbsence, 'message'=>"Absolute yesterDay"]);

    }







}
