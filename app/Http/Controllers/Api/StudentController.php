<?php

namespace App\Http\Controllers\Api;

use App\Models\Student;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;


class StudentController extends Controller
{
    public function index()
    {
        $students = Student::all();

        if($students->count() > 0){
            return response()->json([
                'status' => 200,
                'students' => $students
            ], 200);
        }else{
            return response()->json([
                'status' => 404,
                'message' => 'No Records Found'
            ], 404);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:191',
            'state' => 'required|string|max:191',
            'email' => 'required|email|max:191',
            'phone' => 'required|digits:10',
        ] );

        if($validator->fails()){
            return response()->json([
                'status'=> 422,
                "errors"=> $validator->messages()
            ], 422);
        }else{
            $student= Student::create([
                'name' => $request->name,
                'state' => $request->state,
                'email' => $request->email,
                'phone' => $request->phone,
            ]);

            if($student){
                return response()->json([
                    "status"=>200,
                    'message'=> 'student created successfully'
                ], 200);
            }else{
                return response()->json([
                    "status"=>500,
                    'message'=> 'something went wrong'
                ], 500);
            }

        }
    }
    public function show($id)
    {
        $student = Student::find($id);

        if($student){
            return response()->json([
                'status'  => 200,
                'students' => 'students created succesfully'
            ], 200);
        }else{
            return response()->json([
                'status' => 404,
                'message' => 'No Students Found'
            ], 404);
        }


    }

    public function edit($id )
    {
        $student = Student::find($id);

        if($student){
            return response()->json([
                'status'  => 200,
                'students' => 'students created succesfully'
            ], 200);
        }else{
            return response()->json([
                'status' => 404,
                'message' => 'No Students Found'
            ], 404);
        }
    }

    public function update(Request $request, int $id)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:191',
            'state' => 'required|string|max:191',
            'email' => 'required|email|max:191',
            'phone' => 'required|digits:10',
        ] );

        if($validator->fails()){
            return response()->json([
                'status'=> 422,
                "errors"=> $validator->messages()
            ], 422);
        }else{
            $student= Student::find($id);
            if($student){

                $student->update([
                    'name' => $request->name,
                    'state' => $request->state,
                    'email' => $request->email,
                    'phone' => $request->phone,
                ]);

                return response()->json([
                    "status"=>200,
                    'message'=> 'student updated successfully'
                ], 200);
            }else{
                return response()->json([
                    "status"=>500,
                    'message'=> 'no student found'
                ], 500);
            }

        }
    }
    public function destroy($id)
    {
        $student = Student::find($id);
        if($student){
            $student->delete();
            return response()->json([
                'status' => 200,
                'message'=> 'Student deleted successfully'
            ], 200);

        }else{
            return response()->json([
                'status' => 404,

                'message' => "No student found!"
            ], 404);
        }
    }
}
