<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ProvinceCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return parent::toArray($request);
        /*return [
            'data' => $this->collection->map(function ($item) {
                return [
                    'name' => $item->name,
                    'is_active' => $item->is_active
                ];
            })
        ];*/
    }
}
