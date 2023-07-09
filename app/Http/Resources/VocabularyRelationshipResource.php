<?php

namespace App\Http\Resources;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VocabularyRelationshipResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "vocabulary" => new VocabularyResource($this->vocabulary_relationship_vocabulary),
            "relationship" => $this->relationship
        ];
    }
}
