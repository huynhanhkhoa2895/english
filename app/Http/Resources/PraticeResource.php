<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\PraticeQuestionResource;

class PraticeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $media = $this->getFirstMedia();
        return [
            "id" => $this->id,
            "name" => $this->name,
            "level" =>  $this->level,
            "type" =>  $this->type,
            "instructions" =>  $this->instructions,
            "content" =>  $this->content,
            "media" => [
                "url" => empty($media) ? null : $media->getUrl(),
                "type" =>empty($media) ? null :  $media->mime_type
            ],
            "link_video" => $this->link_video,
            "questions" => PraticeQuestionResource::collection($this->whenLoaded("questions")->load("contents") ?? []),
            "createdAt" => $this->created_at
        ];
    }
}
