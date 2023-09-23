<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\MosqueeIndexRequest;
use App\Http\Resources\MosqueeResource;
use App\Models\Mosquee;
use FaithFM\SmartSearch\SmartSearch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MosqueeController extends Controller
{
    public function index(MosqueeIndexRequest $request)
    {
        $fields = [
            'uuid',
            'name',
            'latitude',
            'longitude',
            'address',
        ];
        $pattern = '/[a-zA-Z0-9 , .]/m';
        $coordinates = [
            'lat' => $request->latitude,
            'lng' => $request->longitude,
        ];
        $search = $request->q;
        $coditional = isset($search) && ! empty($search) && preg_match($pattern, $search);

        if (! empty($coordinates['lat']) && ! empty($coordinates['lng'])) {
            $fields[] = DB::raw('
                ACOS(COS(RADIANS(`latitude`)) *
                COS(RADIANS('.$coordinates['lat'].')) *
                COS(RADIANS('.$coordinates['lng'].') - RADIANS(`longitude`)) +
                SIN(RADIANS(`latitude`)) *
                SIN(RADIANS('.$coordinates['lat'].'))) *
                6378137
                AS `distance`
            ');
        }

        $model = Mosquee::select($fields);
        $model = $model->when($coditional && strlen($search) < 250, function($model) use ($search) {
            // $words = explode(' ', $search);
            // foreach ($words as $key => $word) {
            //     // if (isset($words[$key - 1])) {
            //     //     $word = $words[$key - 1].' '.$word;
            //     // }

            //     // $words[$key] = $word;

            //     $model->orWhere('name', 'like', '%'.$word.'%');
            // }
            $search = new SmartSearch($search, 'name|address');
            $model->where($search->getBuilderFilter());
        })->latest();
        if (! empty($coordinates['lat']) && ! empty($coordinates['lng'])) {
            $model = $model->orderBy('distance', 'asc');
        }
        return MosqueeResource::make($model->cursorPaginate(100));
    }

    public function show(Mosquee $mosquee)
    {
        return [
            'id' => $mosquee->id,
            'name' => $mosquee->name,
            'street' => $mosquee->street,
            'district' => $mosquee->district,
            'city' => $mosquee->city,
            'province' => $mosquee->province,
            'address' => $mosquee->address,
            'distance' => 20,
            'images' => $mosquee->images()->select('source', 'type', 'created_at')->limit(9)->get(),
            'contacts' => $mosquee->contacts()->select('name', 'phone', 'type')->limit(9)->get(),
        ];
    }
}
