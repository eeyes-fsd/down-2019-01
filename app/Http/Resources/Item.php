<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Item extends JsonResource
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
            'name' => $this->name,
            'description' => $this->description,
            'crack' => $this->crack,
            'icon_path' => $this->icon_path,
            'win_id' => $this->win_id,
            'mac_id' => $this->mac_id,
            'rank' => $this->rank,
            'enable' => $this->enable,
        ];
    }
}
