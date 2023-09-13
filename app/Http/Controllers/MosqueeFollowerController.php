<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Mosquee;
use App\Models\Mosquee_follower;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;

class MosqueeFollowerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('mosquee_followers.index', [
            'all_mosquee_follower' => Mosquee_follower::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('mosquee_followers.create', [
            'all_mosquee' => Mosquee::all(),
            // 'all_user' => User::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'mosquee_id' => 'required',
            // 'user_id' => ''
        ]);

        $request['uuid'] = Uuid::uuid4();

        Mosquee_follower::create($request->all());

        return redirect()->route('mosquee_followers.index')->with('success', 'Berhasil');
    }

    /**
     * Display the specified resource.
     */
    public function show(Mosquee_follower $mosquee_follower)
    {
        //
    }

    public function detail(Mosquee_follower $mosquee_follower)
    {
        return view('mosquee_followers.detail', [
            'mosquee_follow' => $mosquee_follower
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Mosquee_follower $mosquee_follower)
    {
        return view('mosquee_followers.edit', [
            'old_data' => $mosquee_follower,
            'all_mosquee' => Mosquee::all(),
            // 'all_user' => User::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Mosquee_follower $mosquee_follower)
    {
        $request->validate([
            'mosquee_id' => 'required',
            // 'user_id' => 'required'
        ]);

        $request['uuid'] = Uuid::uuid4();

        $mosquee_follower->update($request->all());

        return redirect()->route('mosquee_followers.index')->with('success', 'Berhasil');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Mosquee_follower $mosquee_follower)
    {
        $mosquee_follower->delete();

        return redirect()->route('mosquee_followers.index')->with('success', 'Deleted Successfully');
    }
}
