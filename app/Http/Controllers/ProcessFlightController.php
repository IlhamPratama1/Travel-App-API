<?php

namespace App\Http\Controllers;

use App\Models\FlightBook;
use App\Models\ProcessFlight;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProcessFlightController extends Controller
{
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProcessFlight  $processFlight
     * @return \Illuminate\Http\Response
     */
    public function refund($id)
    {     
        $processFlight = ProcessFlight::where('flight_book_id', $id);
        if($processFlight === null) {
            return response()->json([
                'message' => 'Processflight not found',
                'status' => Response::HTTP_NOT_FOUND
            ], Response::HTTP_OK);
        }

        $processFlight->update([
            'flight_book_id' => $id,
            'status' => 'refunded'
        ]);

        return response()->json([
            'message' => 'Refund success',
            'status' => Response::HTTP_OK
        ], Response::HTTP_OK);
    }
}
