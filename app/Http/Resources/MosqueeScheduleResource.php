<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class MosqueeScheduleResource extends ResourceCollection
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'data' => $this->collection->map(function ($row) {
                return [
                    'id' => $row->uuid,
                    'title' => $row->title,
                    'speakers' => $row->speakers,
                    'type' => $row->type,
                    'time' => [
                        'start' => $row->start_time,
                        'end' => $row->end_time,
                    ],
                    'created' => $row->created_at,
                    'updated' => $row->updated_at,
                    'mosquee' => [
                        'name' => $row->mosquee->name,
                        'address' => $row->mosquee->address,
                        'street' => $row->mosquee->street,
                        'district' => $row->mosquee->district,
                        'city' => $row->mosquee->city,
                        'province' => $row->mosquee->province,
                        'latitude' => $row->mosquee->latitude,
                        'longitude' => $row->mosquee->longitude,
                        'distance' => $row->distance / 1000,
                    ],
                ];
            }),
        ];
    }
}
