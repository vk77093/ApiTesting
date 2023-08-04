<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\School\Subject;
use Illuminate\Http\Request;


class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data=Subject::latest()->get();
       // dd($data);
        if($data===null){
            return response()->json([
                'message'=>'No data Found'
            ]);
        }else{
            return response()->json($data);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'subject_name'=>'required|unique:subjects',
            'subject_code'=>'required|integer|unique:subjects'
        ]);
Subject::create($request->all());
        return response()->json([
            'message'=>'Data Added Successfully',
        ],201);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data=Subject::findorFail($id);
        if($data===null){
return response()->json([
    'message'=>'No Matching id is Found'.$id,
]);
        }else{
            return response()->json($data);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    private function ShowData($id){
        $data=Subject::findOrFail($id);
        if($data===null){
            return null;
        }else{
            return $data;
        }
    }
    public function update(Request $request, string $id)
    {
        $request->validate([
            'subject_name'=>'required|unique:subjects,subject_name,'.$id,
            'subject_code'=>'required|integer|unique:subjects,subject_code,'.$id,
        ]);
        $data=$this->ShowData($id);
        $data->update($request->all());
        return response()->json([
            'message'=>'Data updated Successfully',
        ],201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
$data=$this->ShowData($id);
$data->delete();
return response()->json([
    'message'=>'Data deleted Successfully',
],201);
    }
}
