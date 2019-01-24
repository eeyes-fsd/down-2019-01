<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class File extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'size' => readable_size($this->size),
            'version' => $this->version,
            'available' => $this->available,
        ];
    }
}
