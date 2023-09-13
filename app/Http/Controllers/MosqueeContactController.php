<?php

namespace App\Http\Controllers;

use App\Models\Mosquee;
use Illuminate\Http\Request;
use App\Models\Mosquee_contact;
use App\Http\Controllers\Controller;

class MosqueeContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('mosquee_contact.index', [
            'all_mosquee_contact' => Mosquee_contact::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('mosquee_contact.create', [
            'all_mosquees' => Mosquee::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Mosquee_contact::create([
            'mosquee_id' => $request->input('mosquee_id'),
            'name' => $request->input('name'),
            'phone' => $request->input('phone'),
            'type' => $request->input('type') ?? $request->input('phone')
        ]);

        return redirect()->route('mosquee_contact.index')->with('success', 'Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Mosquee_contact $mosquee_contact)
    {
        return view('mosquee_contact.show', [
            'mosquee_contact' => $mosquee_contact
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Mosquee_contact $mosquee_contact)
    {
        return view('mosquee_contact.edit', [
            'old_mosquee_contact' => $mosquee_contact,
            'all_mosquee' => Mosquee::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Mosquee_contact $mosquee_contact)
    {
        $validate = $request->validate([
            'mosquee_id' => 'required',
            'name' => 'required',
            'phone' => 'required',
            'type' => 'required'
        ]);

        $mosquee_contact->update($validate);

        return redirect()->route('mosquee_contact.index')->with('success', 'Berhasil');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Mosquee_contact $mosquee_contact)
    {
        $mosquee_contact->delete();

        return redirect()->route('mosquee_contact.index')->with('success', 'Berhasil');
    }
}
