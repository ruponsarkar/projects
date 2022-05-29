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
// return $request->selectedClass;
        $selectedClass= $request->selectedClass;
        $selectedMonth= $request->selectedMonth;
        
        $students = student::where('class', '=', $selectedClass)->get();

        foreach($students as $data){
            $att[] = attendance::where('roll', $data->rollno)->where('class_id', $data->class)
            ->where('date', 'LIKE', "%{$selectedMonth}%")
            ->get();

            
        }
        $finl = attendance::where('class_id', $selectedClass)->orderBy('roll')->get()->groupBy('roll');

        $list[] = attendance::where('class_id', $selectedClass)->get();

        $a = attendance::select("*")
        ->where('class_id', $selectedClass)
        ->orderBy('roll')
        ->whereBetween('date', [$selectedMonth.'-01', $selectedMonth.'-31'])
        
        ->get();
        
        $results = DB::table('students')
    ->join('attendances', 'students.rollno', '=', 'attendances.roll')
    ->where('students.class', $selectedClass)
    ->where('attendances.class_id', $selectedClass)
    ->get();
       
        return response()->json(['a'=>$a, 'fin'=>$finl,'att'=> $att,'students' => $students, 'status'=>200, 'month'=> $selectedMonth, 'list'=> $list, 'results'=>$results ]);
    }
}
