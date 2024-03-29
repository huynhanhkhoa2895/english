<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LessonResource extends JsonResource
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
            "vocabularies" => VocabularyWithRelationshipResource::collection($this->whenLoaded("vocabularies")->load("categories")),
            "interview_questions" => InterviewQuestionResource::collection($this->whenLoaded("interviewQuestions")),
            "createdAt" => $this->created_at
        ];
    }
}
