<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'subject' => $this->subject,
            'img' => $this->img,
            'doctor'=> new UserResource($this->doctor),
            'num_comments'=> $this->num_comments,
            'num_likes'=> $this->num_likes,
            'created_at' => $this->updated_at->diffForHumans()

        ];
    }
}
