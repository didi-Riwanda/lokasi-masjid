<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Mosquee;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;

class MosqueeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('mosquee.index',[
            'all_mosquee' => Mosquee::all(),
        ]);
    }


    public function countFollowers(Mosquee $masjidId)
    {
        $masjid = Mosquee::findOrFail($masjidId);
        $followerCount = $masjid->followers->count();

        return "Masjid " . $masjid->nama . " memiliki " . $followerCount . " follower.";
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('mosquee.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            // 'uuid' => 'required',
            'name' => 'required',
            'addrees' => 'required|max:350',
            'street' => 'required',
            'subdistrict' => 'required',
            'city' => 'required',
            'province' => 'required',
            'latitude' => 'required',
            'longtitude' => 'required',
            'followers' => 'required',
            'shareds' => 'required'
        ]);

        $request['uuid'] = Uuid::uuid4();
        
        Mosquee::create($request->all());

        return redirect()->route('mosquee.index')->with('success', 'Berhasil');
    }

    /**
     * Display the specified resource.
     */
    public function show(Mosquee $mosquee)
    {
        
    }

    public function detail(Mosquee $mosquee){
        return view('mosquee.detail', [
            'mosquee' => $mosquee
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Mosquee $mosquee)
    {
        return view('mosquee.edit', [
            'old_mosquee' => $mosquee
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Mosquee $mosquee)
    {
        $request->validate([
            // 'uuid' => 'required',
            'name' => 'required',
            'addrees' => 'required|max:350',
            'street' => 'required',
            'subdistrict' => 'required',
            'city' => 'required',
            'province' => 'required',
            'latitude' => 'required',
            'longtitude' => 'required',
            'followers' => 'required',
            'shareds' => 'required'
        ]);

        $request['uuid'] = Uuid::uuid4();
        
        $mosquee->update($request->all());

        return redirect()->route('mosquee.index')->with('success', 'Berhasil');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Mosquee $mosquee)
    {
        $mosquee->delete();
        
        return redirect()->route('mosquee.index')->with('success', 'Data Berhasil dihapus!');
    }
}
