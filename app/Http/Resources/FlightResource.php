<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FlightResource extends JsonResource
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
            'code' => $this->code,
            'airline' => $this->airline,
            'flight_time' => $this->flight_time,
            'arrival_time' => $this->arrival_time,
            'from_city_name' => $this->from_city_name,
            'to_city_name' => $this->to_city_name,
            'price' => $this->price,
            'seat_type' => $this->seat_type,
            'seat_available' => $this->seat_available,
            'baggage' => $this->baggage
        ];
    }
}
