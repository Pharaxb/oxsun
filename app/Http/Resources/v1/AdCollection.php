<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class AdCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return
            [
                /**
                 * The list of Ads.
                 * @var array{uuid: string, title: string, description: string, file: string, file_type: string, cost: int}
                 */
                'rows' => $this->collection->map(function ($item)
                {
                    $fileType = ($item->file_type == "P") ? "image" : "video";
                    $fullPath = 'media/ads/'.$item->user_id.'/'.$fileType.'/'.$item->file;
                    $file = asset($fullPath);
                    $cost = ((100 - $item->commission)/100) * $item->cost;
                    return [
                        'uuid' => $item->uuid,
                        'title' => $item->title,
                        'description' => $item->description,
                        'file' => $file,
                        'file_type' => $item->file_type,
                        'cost' => $cost
                    ];
                }),
                'pagination' => [
                    'total' => $this->total(),
                    'count' => $this->count(),
                    'per_page' => $this->perPage(),
                    'current_page' => $this->currentPage(),
                    'total_pages' => $this->lastPage()
                ]
            ];
    }
}
