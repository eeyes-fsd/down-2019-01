<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserComments extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $comments = [];
        foreach ($this->comments as $comment) {
            $tmp = [
                'content' => $comment->content,
                'created_at' => $comment->created_at,
            ];
            $comments[] = $tmp;
        }

        return [
            'id' => $this->id,
            'name' => $this->name,
            'comments' => $comments,
            'active_at' => $this->active_at,
        ];
    }
}
