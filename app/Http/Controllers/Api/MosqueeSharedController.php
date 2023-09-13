<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Mosquee_shared;
use App\Http\Controllers\Controller;
use App\Http\Resources\MosqueeResource;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\Mosquee_sharedResource;

class MosqueeSharedController extends Controller
{
    public function index(){
        $mosquee_shared = Mosquee_shared::latest()->paginate(5);

        return new Mosquee_sharedResource(true, 'All Mosquee', $mosquee_shared);
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            // 'user_id' => Auth::check() ?? '',
            'ip_address' => 'required',
        ]); 

        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }

        $mosquee_shared = Mosquee_shared::create($request->all());

        return new Mosquee_sharedResource(true, 'Successfully', $mosquee_shared);
    }

    public function show($id){
        $mosquee_shared = Mosquee_shared::find($id);
        return new Mosquee_sharedResource(true, 'Mosquee Detail', $mosquee_shared);
    }

    public function update(Request $request, $id)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            // 'user_id' => Auth::check() ?? '',
            'ip_address' => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //find post by ID
        $mosquee_shared = Mosquee_shared::find($id);

        $mosquee_shared->update($request->all());
        
        
        //return response
        return new Mosquee_sharedResource(true, 'Updated Successfully', $mosquee_shared);
    }

    public function destroy($id){
        $mosquee_shared = Mosquee_shared::find($id);

        $mosquee_shared->delete();

        return new Mosquee_sharedResource(true, 'Deleted Successfully', null);
    }
}
