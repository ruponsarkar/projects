<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\AttendanceController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('student/{selectedClass}', [StudentController::class, 'student']);
Route::post('submitAttendance/', [StudentController::class, 'submitAttendance']);

Route::post('getStudent/', [AttendanceController::class, 'getStudent']);

Route::post('checkAttendance/', [AttendanceController::class,'checkAttendance']);

Route::post('lastDayAbsenca', [AttendanceController::class,'lastDayAbsenca']);
