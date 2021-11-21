<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FlightBook extends Model
{
    use HasFactory;

    protected $table = 'flight_books';

    protected $primaryKey = 'id';

    protected $fillable = [
        'flight_code',
        'flight_id',
        'user_id',
        'seat_number'
    ];

    public function flight() {
        return $this->belongsTo(Flight::class, 'flight_id');
    }

    public function passangers() {
        return $this->hasMany(Passanger::class, 'flight_book_id');
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }
}
