<?php

namespace App\Http\Resources;

use App\Facades\Sqids;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ExpenseResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => Sqids::encode($this->id),
            'date' => $this->date,
            'category' => $this->category,
            'amount' => (float) $this->amount,
            'description' => $this->description,
            'created_at' => $this->created_at,
        ];
    }
}
