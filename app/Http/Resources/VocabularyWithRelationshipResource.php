<?php

namespace App\Http\Resources;

use App\Models\Category;
use App\Models\Vocabulary;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VocabularyWithRelationshipResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = new VocabularyResource($this);
        return array_merge($data->toArray($request), [
            "relationship" => VocabularyRelationshipResource::collection($this->whenLoaded('vocabulary_relationship_main') ?? [])
        ]);
    }
}
