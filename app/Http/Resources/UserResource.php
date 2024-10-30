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
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'transactions_count' => $this->whenCounted('transactions'),
            'created_at' => date('Y-m-d H:i a', strtotime($this->created_at)),
            'updated_at' => date('Y-m-d H:i a', strtotime($this->updated_at)),
        ];
    }
}
