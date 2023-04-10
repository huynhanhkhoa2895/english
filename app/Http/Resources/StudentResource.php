<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentResource extends JsonResource
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
            "name" => $this->name,
            "email" =>  $this->email,
            "position" =>  $this->position,
            "practices" => PraticeResource::collection($this->whenLoaded("practices")->load("questions") ?? []),
            "lessons" => LessonResource::collection($this->whenLoaded("lessons")->load("vocabularies") ?? []),
        ];
    }
}
