<?php

namespace App\Http\Controllers;

use App\Http\Requests\FlightRequest;
use App\Models\Flight;
use Symfony\Component\HttpFoundation\Response;

class FlightController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Flight::paginate(5);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FlightRequest $request)
    {
        $request->validated();
        
        $code = time() . '-' . $request->airline_id . '-' . $request->seat_type;
        
        $flight = Flight::create([
            'code' => $code,
            'airline_id' => $request->airline_id,
            'flight_time' => $request->flight_time,
            'arrival_time' => $request->arrival_time,
            'from_city_name' => $request->from_city_name,
            'to_city_name' => $request->to_city_name,
            'price' => $request->price,
            'seat_type' => $request->seat_type,
            'seat_available' => $request->seat_available,
            'baggage' => $request->baggage
        ]);

        return response()->json([
            'message' => 'Flight created',
            'data' => $flight,
            'status' =>Response::HTTP_CREATED
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Flight  $flight
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $flight = Flight::where('id', $id)->first();
        
        if($flight === null) {
            return response()->json([
                'message' => 'Flight not found',
                'status' => Response::HTTP_NOT_FOUND
            ], Response::HTTP_NOT_FOUND);
        }

        return $flight;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Flight  $flight
     * @return \Illuminate\Http\Response
     */
    public function update(FlightRequest $request, $id)
    {
        $flight = Flight::where('id', $id)->first();

        if ($flight === null) {
            return response()->json([
                'message' => 'Flight not found',
                'status' => Response::HTTP_NOT_FOUND
            ], Response::HTTP_NOT_FOUND);
        }

        $request->validated();

        $flight->update([
            'airline_id' => $request->airline_id,
            'flight_time' => $request->flight_time,
            'arrival_time' => $request->arrival_time,
            'from_city_name' => $request->from_city_name,
            'to_city_name' => $request->to_city_name,
            'price' => $request->price,
            'seat_type' => $request->seat_type,
            'seat_available' => $request->seat_available,
            'baggage' => $request->baggage
        ]);

        return response()->json([
            'message' => 'Flight updated',
            'status' =>Response::HTTP_OK
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Flight  $flight
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $flight = Flight::where('id', $id)->first();

        if ($flight === null) {
            return response()->json([
                'message' => 'flight already deleted',
                'status' => Response::HTTP_OK
            ], Response::HTTP_OK);
        }

        $flight->delete();

        return response()->json([
            'message' => 'flight deleted',
            'status' => Response::HTTP_OK
        ], Response::HTTP_OK);
    }
}
