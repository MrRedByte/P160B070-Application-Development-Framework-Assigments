<?php

namespace App\Http\Controllers;

use App\Models\Lecturer;
use Illuminate\Http\Request;

class LecturersController extends Controller
{
    public function index(){
        $lecturers = Lecturer::all();
        return view('lecturers.index', compact('lecturers'));
    }

    public function create(){
        return view('lecturers.create');
    }

    public function store(Request $request){
        $lecturer = new Lecturer();
        $lecturer->name=$request->name;
        $lecturer->surname=$request->surname;
        $lecturer->phone=$request->phone;
        $lecturer->email=$request->email;
        $lecturer->birthday=$request->birthday;
        $lecturer->save();

        return redirect()->route('lecturers.index');
    }

    public function edit($id){
        $lecturer=Lecturer::find($id);
        return view('lecturers.update',compact('lecturer'));
    }

    public function update(Request $request,$id)
    {
        $lecturer = Lecturer::find($id);
        $lecturer->name=$request->name;
        $lecturer->surname=$request->surname;
        $lecturer->phone=$request->phone;
        $lecturer->email=$request->email;
        $lecturer->birthday=$request->birthday;
        $lecturer->save();

        return redirect()->route('lecturers.index');
    }

    public function delete($id){
        $lecturer=Lecturer::find($id);
        $lecturer->delete();
        return redirect()->route('lecturers.index');
    }
}
