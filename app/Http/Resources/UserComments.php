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
                'is_admin' => $comment->admin,
                'content' => $comment->content,
                'created_at' => $comment->created_at->toDateTimeString(),
            ];
            $comments[] = $tmp;
        }

        return [
            'id' => $this->id,
            'name' => $this->name,
            'comments' => $comments,
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}
