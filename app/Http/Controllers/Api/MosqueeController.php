<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\MosqueeResource;
use App\Models\Mosquee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Ramsey\Uuid\Uuid;

class MosqueeController extends Controller
{
    public function index(){
        $mosquees = Mosquee::latest()->paginate(5);

        return new MosqueeResource(true, 'All Mosquee', $mosquees);
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
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

        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }

        $request['uuid'] = Uuid::uuid4();
        // $request->input('uuid') = Uuid::uuid4();

        $mosquees = Mosquee::create($request->all());

        return new MosqueeResource(true, 'Successfully', $mosquees);
    }

    public function show($id){
            $mosquee = Mosquee::find($id);
            return new MosqueeResource(true, 'Mosquee Detail', $mosquee);
    }

    public function update(Request $request, $id)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
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

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //find post by ID
        $mosquee = Mosquee::find($id);

        $mosquee->update($request->all());
        
        
        //return response
        return new MosqueeResource(true, 'Updated Successfully', $mosquee);
    }

    public function destroy($id){
        $mosquee = Mosquee::find($id);

        $mosquee->delete();

        return new MosqueeResource(true, 'Deleted Successfully', null);
    }
}
