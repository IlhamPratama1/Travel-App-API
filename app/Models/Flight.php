<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Flight extends Model
{
    use HasFactory;

    protected $table = 'flights';

    protected $primaryKey = 'id';

    protected $fillable = [
        'code',
        'airline_id',
        'flight_time',
        'arrival_time',
        'from_city_name',
        'to_city_name',
        'price',
        'seat_type',
        'seat_available',
        'baggage'
    ];

    public function airline() {
        return $this->belongsTo(Airline::class, 'airline_id');
    }

    public function flightBooks() {
        return $this->hasMany(FlightBook::class, 'flight_id');
    }
}
