<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ResultResource extends JsonResource
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
            "student" => new StudentResource($this->whenLoaded("student")),
            "id" => $this->id,
            "id" => $this->id,
            "id" => $this->id,
            "id" => $this->id,
        ];
    }
}
