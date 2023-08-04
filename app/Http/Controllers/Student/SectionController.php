<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\School\StuSection;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data=StuSection::latest()->get();
       if($data ===null){
return response()->json([
    'message'=>'No data Found',
],204);
       }else{
        return response()->json([
            'data'=>$data,
        ],202);
       }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'class_id'=>'required|integer',
            'section_name'=>'required|unique:stu_sections,section_name'
        ]);
        $data=StuSection::create($request->all());
        return response()->json([
            'message'=>'Student Section Created Successfully',
        ],201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data=StuSection::findorFail($id);
        return response()->json([
            'data'=>$data,
        ],202);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'class_id'=>'required|integer',
            'section_name'=>'required|unique:stu_sections,section_name,'.$id,
        ]);
    $data=StuSection::findorFail($id);
    $data->update($request->all());
    return response()->json([
        'message'=>'Data Updated Successfully',
    ],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
$data=StuSection::find($id);
//dd($data);
if($data==null){

    return response()->json([
        'message'=>'No data Found Againsit Id '.$id,
    ],204);
}else{
    $data->delete();
    return response()->json([
        'message'=>'Data Got Deleted',
    ],200);
}
    }
}
