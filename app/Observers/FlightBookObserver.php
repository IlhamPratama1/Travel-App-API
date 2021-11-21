<?php

namespace App\Observers;

use App\Models\FlightBook;
use App\Models\ProcessFlight;

class FlightBookObserver
{
    /**
     * Handle the FlightBook "created" event.
     *
     * @param  \App\Models\FlightBook  $flightBook
     * @return void
     */
    public function created(FlightBook $flightBook)
    {
        ProcessFlight::create([
            'flight_book_id' => $flightBook->id,
            'status' => 'processed'
        ]);
    }
}
