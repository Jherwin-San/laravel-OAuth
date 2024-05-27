<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "Id" => $this->id,
            "UserId" => $this->user_id,
            "Title" => $this->title,
            "Description" => $this->description,
            "Status" => $this->status,
            "DateAdded" => $this->date_added,
            "FinishedDate" => $this->finished_date,
        ];
    }
}
