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
                    'name' => $row->name,
                    'latitude' => $row->latitude,
                    'longitude' => $row->longitude,
                    'address' => $row->address,
                    'distance' => $row->distance / 1000,
                ];
            }),
        ];
    }
}
