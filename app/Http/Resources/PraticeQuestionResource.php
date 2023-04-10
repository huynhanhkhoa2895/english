<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PraticeQuestionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "type" => $this->type,
            "title" =>  $this->title,
            "description" =>  $this->description,
            "contents" => PraticeQuestionContentResource::collection($this->whenLoaded("contents")),
            "createdAt" => $this->created_at
        ];
    }
}
