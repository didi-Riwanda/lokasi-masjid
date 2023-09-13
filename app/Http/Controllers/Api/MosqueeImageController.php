<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Mosquee_imageResource;
use App\Http\Resources\MosqueeResource;
use App\Models\Mosquee_image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class MosqueeImageController extends Controller
{
    public function index(){
        $mosquee_images = Mosquee_image::latest()->paginate(5);

        return new Mosquee_imageResource(true, 'All Mosquee Images', $mosquee_images);
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'mosquee_id' => 'required',
            'source' => 'image|file|max:1024',
            'type' => 'required'
        ]); 

        // if($request->file('source')){
        //     $validator['source'] = $request->file('source')->store('mosquee_images');
        // }

        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }

        // //upload image
        // $image = $request->file('source');
        // $image->storeAs('storage/mosquee_images', $image->hashName());

        // $image = $request->file('source');
        // if($image){
        //     $image = $request->file('source')->store('mosquee_images');
        // }

        $image = $request->file('source');
        $image->store('mosquee_images');

        $mosquees = Mosquee_image::create($request->all());

        return new Mosquee_imageResource(true, 'Successfully', $mosquees);
    }

    public function show(Mosquee_image $mosquee_image){
        return new Mosquee_imageResource(true, 'Detail Mosquee Images', $mosquee_image);
    }

    public function update(Request $request, Mosquee_image $mosquee_image)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'mosquee_id' => 'required',
            'source' => 'image|file|max:1024',
            'type' => 'required'
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //check if image is not empty
        if ($request->hasFile('source')) {

            //upload image
            $image = $request->file('source');
            $image->store('mosquee_images');

            //delete old image
            Storage::delete($mosquee_image->source);

            //update post with new image
            $mosquee_image->update([
                'mosquee_id' => 'required',
                'source' => 'image|file|max:1024',
                'type' => 'required'
            ]);

        } else {

            $mosquee_image->update([
                'mosquee_id' => 'required',
                'source' => 'image|file|max:1024',
                'type' => 'required'
            ]);
        }

        //return response
        return new Mosquee_imageResource(true, 'Data Post Berhasil Diubah!', $mosquee_image);
    }

    public function destroy(Mosquee_image $mosquee_image)
    {
        //delete image
        // Storage::delete('public/posts/'.$post->image);

        // //delete post
        // $post->delete();

        // //return response
        // return new PostResource(true, 'Data Post Berhasil Dihapus!', null);

        // if($mosquee_image->source){
            Storage::delete('mosquee_images' . $mosquee_image->source);

            $mosquee_image->delete();

            return new Mosquee_imageResource(true, 'Data Berhasil Dihapus', null);
        // }
    }
}

