<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\student;
use App\Models\attendance;

class AttendanceController extends Controller
{
    //
    function getStudent(Request $request){
// return $request->selectedClass;
        $selectedClass= $request->selectedClass;
        $selectedMonth= $request->selectedMonth;

        $students = student::where('class', '=', $selectedClass)->get();

        foreach($students as $data){
            $list[] = attendance::where('sid', $data->id)->where('date','LIKE','%'.$selectedMonth.'%')->get();
            // $i=1;
            // $a[$i] = $list->
        }
       
        return response()->json(['students' => $students, 'status'=>200, 'month'=> $selectedMonth, 'list'=> $list ]);
    }
}
