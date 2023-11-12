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
        $melocated = ! empty($coordinates['lat']) && ! empty($coordinates['lng']);

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
            $search = new SmartSearch($search, 'name');
            $model->where($search->getBuilderFilter());
        });
        if ($coditional && strlen($search) < 250 && $melocated) {
            $model = $model->orderBy('distance', 'asc');
        } else {
            $model = $model->latest();
        }
        return MosqueeResource::make($model->cursorPaginate(100));
    }

    public function show(Mosquee $mosquee, Request $request)
    {
        $lat = $request->latitude ?? 0;
        $lng = $request->longitude ?? 0;
        $distance = acos(
            cos(deg2rad($mosquee->latitude)) *
            cos(deg2rad($lat)) *
            cos(deg2rad($lng) - deg2rad($mosquee->longitude)) +
            sin(deg2rad($mosquee->latitude)) *
            sin(deg2rad($lat))
        ) * 6378137;
        $images = $mosquee->images()->select('source', 'type')->limit(5)->get();
        $now = gmdate('Y-m-d H:i');

        return [
            'id' => $mosquee->uuid,
            'name' => $mosquee->name,
            'street' => $mosquee->street,
            'district' => $mosquee->district,
            'city' => $mosquee->city,
            'province' => $mosquee->province,
            'address' => $mosquee->address,
            'latitude' => $mosquee->latitude,
            'longitude' => $mosquee->longitude,
            'distance' => $distance / 1000,
            'images' => array_map(function ($row) {
                return [
                    'source' => route('image.url', ['path' => $row['source']]),
                    'type' => route('image.url', ['path' => $row['type']]),
                ];
            }, $images->toArray()),
            'contacts' => $mosquee->contacts()->select('name', 'phone', 'type')->limit(9)->get(),
            'schedules' => $mosquee->schedules()->where(function ($model) use ($mosquee, $now) {
                $model->where('mosquee_id', $mosquee->id);
                $model->where(function ($model) use ($now) {
                    $model->where(function ($model) use ($now) {
                        $model->where('type', 'dauroh');
                        $model->where('end_time', '>=', $now);
                    });
                    $model->orWhereIn('type', ['kajian', 'tahsin', 'tahfidz']);
                });
            })->get()->map(function ($row) {
                return [
                    'title' => $row->title,
                    'speakers' => $row->speakers,
                    'start_time' => $row->start_time,
                    'end_time' => $row->end_time,
                    'day' => $row->day,
                    'duration' => $row->duration,
                    'type' => $row->type,
                ];
            }),
        ];
    }
}
