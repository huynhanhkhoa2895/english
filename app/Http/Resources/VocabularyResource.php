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
            "spelling" =>  $this->spelling,
            "example" =>  $this->example,
            "sound" =>  $this->sound,
            "category" => new CategoryResource($this->whenLoaded("categories") ?? null)
        ];
    }
}
