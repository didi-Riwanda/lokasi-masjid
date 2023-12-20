<?php

namespace App\Http\Controllers;

use App\Models\Mosquee;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\MosqueeContact;

class MosqueeContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Mosquee $mosquee, Request $request)
    {
        $model = $mosquee->contacts()->select([
            'id',
            'name',
            'phone',
            'type',
            'created_at',
        ]);
        $model = $model->when(! empty($request->search), function ($query) use ($request) {
            $query->where('name', 'like', '%'.$request->search.'%');
            $query->orWhere('phone', 'like', '%'.$request->search.'%');
        });
        $paginator = $model->cursorPaginate(15);

        return view('mosquee.contact.index', [
            'mosquee' => $mosquee,
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

    /**
     * Show the form for creating a new resource.
     */
    public function create(Mosquee $mosquee)
    {
        return view('mosquee.contact.create', [
            'mosquee' => $mosquee,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Mosquee $mosquee, Request $request)
    {
        $mosquee->contacts()->create([
            'name' => $request->input('name'),
            'phone' => $request->input('phone'),
            'type' => $request->input('type'),
        ]);

        return redirect()->route(
            'mosquee.contact.index',
            ['mosquee' => $mosquee->uuid],
        )->with('success', 'Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Mosquee $mosquee, MosqueeContact $contact)
    {
        return view('mosquee_contact.show', [
            'mosquee_contact' => $contact
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Mosquee $mosquee, MosqueeContact $contact)
    {
        return view('mosquee.contact.edit', [
            'mosquee' => $mosquee,
            'contact' => $contact,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MosqueeContact $mosquee_contact)
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
    public function destroy(Mosquee $mosquee, MosqueeContact $contact)
    {
        $contact = $mosquee->contacts()->find($contact->id);
        optional($contact)->delete();

        return redirect()->route(
            'mosquee.contact.index',
            ['mosquee' => $mosquee->uuid],
        )->with('success', 'Berhasil');
    }
}
