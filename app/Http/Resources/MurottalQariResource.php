<?php

namespace App\Http\Resources;

use App\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class MurottalQariResource extends ResourceCollection
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
                    'slug' => Str::slug($row->qari),
                    'name' => $row->qari,
                ];
            }),
        ];
    }
}
