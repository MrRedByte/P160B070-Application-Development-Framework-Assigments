<?php

namespace App\Http\Controllers;

use App\Models\Owner;
use Illuminate\Http\Request;

class OwnerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $owners = Owner::all();
       return view('owners.index', compact('owners'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('owners.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Owner::create($request->all());
        return redirect()->route('owners.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Owner $owner)
    {
        // Bu Owner'ın sahip olduğu arabaları alıyoruz
           $cars = $owner->cars;

           // owners/show.blade.php sayfasına gönderiyoruz
           return view('owners.show', compact('owner', 'cars'));
       }
    

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Owner $owner)
    {
        return view('owners.edit', compact('owner'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Owner $owner)
    {
        $owner->update($request->all());
        return redirect()->route('owners.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Owner $owner)
    {
        $owner->delete();
        return redirect()->route('owners.index');
    }
}
