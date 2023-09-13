<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Mosquee_shared;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MosqueeSharedController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('mosquee_shared.index', [
            'all_mosquee_shared' => Mosquee_shared::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('mosquee_shared.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Mosquee_shared::create([
            // 'user_id' => Auth::check() ?? '',
            'ip_address' => $request->input('ip_address'),
        ]);

        return redirect()->route('mosquee_shareds.index')->with('success', 'Berhasil');
    }

    /**
     * Display the specified resource.
     */
    public function show(Mosquee_shared $mosquee_shared)
    {
        return view('mosquee_shared.detail', [
            'mosquee_shared' => $mosquee_shared
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Mosquee_shared $mosquee_shared)
    {
        return view('mosquee_shared.edit', [
            'old_data' => $mosquee_shared
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Mosquee_shared $mosquee_shared)
    {

        $mosquee_shared->update([
            // 'user_id' => Auth::check() ?? '',
            'ip_address' => $request->input('ip_address'),
        ]);

        return redirect()->route('mosquee_shareds.index')->with('success', 'Berhasil');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Mosquee_shared $mosquee_shared)
    {
        $mosquee_shared->delete();

        return redirect()->route('mosquee_shared.index')->with('success', 'Deleted Successfully');
    }
}
