<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProcessFlight extends Model
{
    use HasFactory;

    protected $table = 'process_flights';

    protected $primaryKey = 'id';

    protected $fillable = [
        'flight_book_id',
        'status'
    ];

    public function flightBook() {
        return $this->belongsTo(FlightBook::class, 'flight_book_id');
    }
}
