<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Mosquee;
use App\Models\MosqueeImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MosqueeImageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('mosquee_images.index', [
            'all_mosquee_images' => MosqueeImage::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('mosquee_images.create', [
            'mosquee' => Mosquee::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'mosquee_id' => 'required',
            'source' => 'image|file|max:1024',
            'type' => 'required'
        ]);

        if($request->file('source')){
            $validateData['source'] = $request->file('source')->store('mosquee_images');
        }

        MosqueeImage::create($validateData);

        return redirect()->route('mosquee_images.index')->with('success', 'Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(MosqueeImage $mosquee_image)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MosqueeImage $mosquee_image)
    {
        return view('mosquee_images.edit', [
            'old_mosquee_images' => $mosquee_image,
            'all_mosquee' => Mosquee::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MosqueeImage $mosquee_image)
    {
        $validate = $request->validate([
            'mosquee_id' => 'required',
            'source' => 'image|file|max:1024',
            'type' => 'required'
        ]);

        if($request->file('source')){
            if($request->oldImage){
                Storage::delete($request->oldImage);
            }
            $validate['source'] = $request->file('source')->store('mosquee_images');
        }

        $mosquee_image->update($validate);

        return redirect()->route('mosquee_images.index')->with('success', 'Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MosqueeImage $mosquee_image)
    {
        if($mosquee_image->source){
            Storage::delete($mosquee_image->source);

            $mosquee_image->delete();

            return redirect()->route('mosquee_images.index')->with('success', 'Successfully');
        }
    }
}
