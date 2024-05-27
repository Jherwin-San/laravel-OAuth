<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'Name' => $this->name,
            'Email' => $this->email,
            'EmailVerifiedAt' => $this->email_verified_at,
            'Role' => $this->role,
            'Password' => $this->password,
            'tasks' => TaskResource::collection($this->whenLoaded('tasks')),
        ];
    }
}
