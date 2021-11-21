<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Passanger extends Model
{
    use HasFactory;

    protected $table = 'passangers';

    protected $primaryKey = 'id';

    protected $fillable = [
        'fullname',
        'type',
        'flight_book_id'
    ];

    public function flightBook() {
        return $this->belongsTo(FlightBook::class, 'flight_book_id');
    }
}
