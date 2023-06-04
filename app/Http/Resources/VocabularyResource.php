<?php

namespace App\Http\Resources;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VocabularyResource extends JsonResource
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
            "vocabulary" => $this->vocabulary,
            "translate" =>  $this->translate,
            "transcript" => $this->spelling,
            "definition" => $this->definition,
            "parts_of_speech" => $this->parts_of_speech,
            "spelling" =>  $this->spelling,
            "example" =>  $this->example,
            "sound" =>  $this->sound,
            "category" => new CategoryResource($this->whenLoaded("categories") ?? null),
            "createdAt" => $this->created_at
        ];
    }
}
