<?php

namespace App\Http\Controllers;

use App\Http\Requests\OwnerRequest;
use App\Models\Owner;

class OwnerController extends Controller
{
    public function index()
    {
        $owners = Owner::with('cars')->get();
        return view('owners.index', compact('owners'));
    }

    public function create()
    {
        return view('owners.create');
    }

    public function store(OwnerRequest $request)
    {
        $request->validate([
            'name' => 'required',
            'surname' => 'required',
            'role' => 'required'
        ]);

        Owner::create([
            'name' => $request->name,
            'surname' => $request->surname,
            'role' => $request->role,
            'user_id' => auth()->id()
        ]);
        return redirect()->route('insurance')
            ->with('success', 'Owner was created successfully.');
    }

    public function show(Owner $owner)
    {
        //
    }

    public function edit(Owner $owner)
    {
        $this->authorize('update', $owner);
        return view('owners.edit', compact('owner'));
    }

    public function update(OwnerRequest $request, Owner $owner)
    {
        $request->validate([
            'name' => 'required',
            'surname' => 'required'
        ]);
        $this->authorize('update', $owner);
        $owner->update($request->all());

        return redirect()->route('insurance')
            ->with('success', 'Owner was updated successfully.');
    }

    public function destroy(Owner $owner)
    {
        $this->authorize('delete', $owner);

        $owner->delete();

        return redirect()->route('insurance')
            ->with('success', 'Owner was deleted successfully.');
    }
}
