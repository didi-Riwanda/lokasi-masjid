<?php

namespace App\Http\Controllers\Api;

use Ramsey\Uuid\Uuid;
use App\Models\Mosquee;
use Illuminate\Http\Request;
use App\Models\Mosquee_contact;
use App\Http\Controllers\Controller;
use App\Http\Resources\MosqueeResource;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\Mosquee_contactResource;

class MosqueeContactController extends Controller
{
    public function index(){
        $mosquee_contact = Mosquee_contact::latest()->paginate(5);

        return new Mosquee_contactResource(true, 'All Mosquee', $mosquee_contact);
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'mosquee_id' => 'required',
            'name' => 'required',
            'phone' => 'required',
            'type' => 'max:12'
        ]); 

        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }

        $mosquee_contact = Mosquee_contact::create([
            'mosquee_id' => $request->input('mosquee_id'),
            'name' => $request->input('name'),
            'phone' => $request->input('phone'),
            'type' => $request->input('type') ?? $request->input('phone')
        ]);

        return new Mosquee_contactResource(true, 'Successfully', $mosquee_contact);
    }

    public function show($id){
        $mosquee_contact = Mosquee_contact::find($id);
        return new Mosquee_contactResource(true, 'Mosquee Detail', $mosquee_contact);
    
    }

    public function update(Request $request, $id)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'mosquee_id' => 'required',
            'name' => 'required',
            'phone' => 'required',
            'type' => 'max:12'
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //find post by ID
        $mosquee_contact = Mosquee_contact::find($id);

        $mosquee_contact->update([
            'mosquee_id' => $request->input('mosquee_id'),
            'name' => $request->input('name'),
            'phone' => $request->input('phone'),
            'type' => $request->input('type') ?? $request->input('phone')
        ]);
        
        
        //return response
        return new Mosquee_contactResource(true, 'Updated Successfully', $mosquee_contact);
    }

    public function destroy($id){
        $mosquee_contact = Mosquee_contact::find($id);

        $mosquee_contact->delete();

        return new Mosquee_contactResource(true, 'Deleted Successfully', null);
    }
}
