<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FlightBookResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'flight' => $this->flight,
            'process' => $this->process,
            'passangers' => $this->passangers,
            'user' => $this->user,
            'seat_number' => $this->seat_number
        ];
    }
}
