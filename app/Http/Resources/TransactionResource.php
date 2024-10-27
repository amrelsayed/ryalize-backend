<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
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
            'amount' => $this->transaction_amount,
            'date' => $this->transaction_date,
            'user' => new UserResource($this->whenLoaded("user")),
            'location' => new LocationResource($this->whenLoaded("location")),
        ];
    }
}
