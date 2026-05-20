<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Owner;
use Illuminate\Http\Request;

class OwnersAPIController extends Controller
{
    public function index()
    {
        return Owner::all();
    }

    public function show($id)
    {
        return Owner::find($id);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:2|max:50',
            'surname' => 'required|min:2|max:50',
            'role' => 'required'
        ]);

        $owner = new Owner();

        $owner->name = $request->name;
        $owner->surname = $request->surname;
        $owner->role = $request->role;

        $owner->save();

        return $owner;
    }

    public function update(Request $request, $id)
    {
        $owner = Owner::find($id);

        $owner->name = $request->name;
        $owner->surname = $request->surname;
        $owner->role = $request->role;

        $owner->save();

        return $owner;
    }

    public function destroy($id)
    {
        Owner::destroy($id);

        return $id;
    }
}
