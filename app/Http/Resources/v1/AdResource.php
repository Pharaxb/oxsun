<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $fileType = ($this->file_type == "P") ? "image" : "video";
        $fullPath = 'media/ads/'.$this->user_id.'/'.$fileType.'/'.$this->file;
        $file = asset($fullPath);
        return [
            'uuid' => $this->uuid,
            'title' => $this->title,
            'description' => $this->description,
            'file' => $file,
            'file_type' => $this->file_type,
            'cost' => $this->cost
        ];
    }
}
