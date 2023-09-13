<?php

namespace App\Http\Controllers\Api;

use Ramsey\Uuid\Uuid;
use App\Models\Mosquee;
use Illuminate\Http\Request;
use App\Models\Mosquee_follower;
use App\Http\Controllers\Controller;
use App\Http\Resources\MosqueeResource;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\Mosquee_followerResource;

class MosqueeFollowerController extends Controller
{
    public function index(){
        $mosquee_follower = Mosquee_follower::latest()->paginate(5);

        return new Mosquee_followerResource(true, 'All Mosquee', $mosquee_follower);
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'mosquee_id' => 'required',
            // 'user_id' => ''
        ]); 

        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }

        $request['uuid'] = Uuid::uuid4();
        // $request->input('uuid') = Uuid::uuid4();

        $mosquees = Mosquee_follower::create($request->all());

        return new Mosquee_followerResource(true, 'Successfully', $mosquees);
    }

    public function show($id){
        $mosquee_follower = Mosquee_follower::find($id);
        return new Mosquee_followerResource(true, 'Mosquee Detail', $mosquee_follower);
    }

    public function update(Request $request, $id)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'mosquee_id' => 'required',
            // 'user_id' => ''
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //find post by ID
        $mosquee_follower = Mosquee_follower::find($id);

        $mosquee_follower->update($request->all());
        
        
        //return response
        return new Mosquee_followerResource(true, 'Updated Successfully', $mosquee_follower);
    }

    public function destroy($id){
        $mosquee_follower = Mosquee_follower::find($id);

        $mosquee_follower->delete();

        return new Mosquee_followerResource(true, 'Deleted Successfully', null);
    }
}
