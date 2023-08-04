<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\School\StuClass;
use Illuminate\Http\Request;

class ClassController extends Controller
{
    public function ShowClass(){
        $classData=StuClass::latest()->get();
        return response()->json($classData);
    }
    public function CreateClass(Request $request){
      $validateData=$request->validate([
            'class_name'=>'required|unique:stu_classes',
        ]);
       $data=StuClass::insert([
        'class_name'=>$request->class_name,
       ]);
       return response('Student data Created Successfully');

    }
    public function EditClass($id){
        $data=StuClass::findorfail($id);
        if($data !==null){
            return response()->json($data);
        }else{
            return response('No Data Found')->json([]);
        }
    }
    public function UpdateClass(Request $request,$id){

      //$data=StuClass::findOrFail($id);
        $request->validate([
            'class_name'=>'required|unique:stu_classes,class_name,'.$id,

        ]);
        StuClass::findOrFail($id)->update([
            'class_name'=>$request->class_name,
        ]);
        return response('data got updated successfully');

    }
    public function DeleteClass($id){
        $data=StuClass::findOrFail($id);
        $data->delete();
        return response('Data Deleted Successfully');
    }
}
