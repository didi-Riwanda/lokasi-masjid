<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Mosquee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

class MosqueeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $model = Mosquee::select([
            'id',
            'name',
            'address',
            'street',
            'district',
            'city',
            'province',
            'created_at',
        ]);
        $model = $model->when(! empty($request->search), function ($query) use ($request) {
            $query->where('name', 'like', '%'.$request->search.'%');
        });
        $paginator = Mosquee::cursorPaginate(15);

        return view('mosquee.index', [
            'paginate' => [
                'data' => $paginator->items(),
                'meta' => [
                    'count' => $paginator->count(),
                    'next' => optional($paginator->nextCursor())->encode(),
                    'previous' => optional($paginator->previousCursor())->encode(),
                ],
            ],
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
            'name' => 'required|string',
            'address' => 'required|string|max:350',
            'street' => 'required|string',
            'district' => 'required|string',
            'city' => 'required|string',
            'province' => 'required|string',
            'latitude' => [
                'required',
                'numeric',
                'regex:/^[-]?(([0-8]?[0-9])\.(\d+))|(90(\.0+)?)$/',
            ],
            'longitude' => [
                'required',
                'numeric',
                'regex:/^[-]?((((1[0-7][0-9])|([0-9]?[0-9]))\.(\d+))|180(\.0+)?)$/',
            ],
            'images.*' => 'nullable|mimes:png,jpg,jpeg|max:2048',
        ]);

        return DB::transaction(function () use ($request) {
            $mosquee = Mosquee::create($request->only([
                'name',
                'address',
                'street',
                'district',
                'city',
                'province',
                'latitude',
                'longitude',
            ]));

            $images = $request->file('images');
            if (is_array($images) && ! empty($images)) {
                foreach ($images as $image) {
                    if (isset($image) && ! empty($image)) {
                        $mosquee->images()->create([
                            'source' => $image->store('mosquees/'.$mosquee->uuid),
                            'type' => $image->extension(),
                        ]);
                    }
                }
            }

            return redirect()->route('mosquee.index')->with('success', 'Berhasil');
        });
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
