<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\School\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data=Student::latest()->get();
        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:students',
            'stu_name' => 'required|string|max:50',
            'stu_pass' => 'required'
        ]);
        if($validator->fails()){
            return response()->json([
                'message'=>$validator->messages()->first(),
            ]);
        }else{
            Student::create($request->all(),[
                'stu_pass'=>Hash::make($request->stu_pass),
            ]);
            return response()->json([
                'message'=>'Data Created Successfully',
            ],201);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data=Student::findorFail($id);
        if($data===null){
            return response()->json([
                'message'=>'data not found',
            ]);
        }else{
            return response()->json($data);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:students,email,'.$id,
            'stu_name' => 'required|string|max:50|unique:students,stu_name,'.$id,
            'stu_pass' => 'required'
        ]);
        if($validator->fails()){
            return response()->json([
                'message'=>$validator->messages()->first(),
            ]);
        }else{
            Student::findorFail($id)->update($request->all(),[
                'stu_pass'=>Hash::make($request->stu_pass),
            ]);
            return response()->json([
                'message'=>'data Updated Successfully',
            ],200);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Student::findOrfail($id)->delete();
        return response('Data Deleted Successfully');
    }
}
