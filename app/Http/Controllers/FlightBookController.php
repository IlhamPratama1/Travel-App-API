<?php

namespace App\Http\Controllers;

use App\Http\Resources\FlightBookResource;
use App\Models\FlightBook;
use App\Models\Passanger;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class FlightBookController extends Controller
{
    /**
     * flightId return all flightBook data by flight_id.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function flightId($id) {
        $flight_books = FlightBook::where('flight_id', $id)->get();
        
        if($flight_books === null) {
            return response()->json([
                'message' => 'Flight not found',
                'status' => Response::HTTP_NOT_FOUND
            ], Response::HTTP_NOT_FOUND);
        }

        return FlightBookResource::collection($flight_books);
    }

    /**
     * myFlightBooks return all flightBook data by user_id.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function myFlightBooks(Request $request) {
        $flight_books = FlightBook::where('user_id', $request->user()->id)->orderBy('created_at')->get();

        if($flight_books === null) {
            return response()->json([
                'message' => 'Flight not found',
                'status' => Response::HTTP_NOT_FOUND
            ], Response::HTTP_NOT_FOUND);
        }

        return FlightBookResource::collection($flight_books);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'flight_id' => 'required',
            'user_id' => 'required',
            'seat_number' => 'required|integer',
            'passangers' => 'required|array'
        ]);

        if(FlightBook::where('seat_number', $request->seat_number)->first()) {
            return response()->json([
                'message' => 'Seat already reserved',
                'status' => Response::HTTP_BAD_REQUEST
            ], Response::HTTP_BAD_REQUEST);
        };

        $flight_code = time() . '-' . $request->flight_id . ':' . $request->user_id . ':' . $request->seat_number;

        $flightBook = FlightBook::create([
            'flight_code' => $flight_code,
            'flight_id' => $request->flight_id,
            'user_id' => $request->user_id,
            'seat_number' => $request->seat_number
        ]);

        foreach ($request->passangers as $key => $value) {
            Passanger::create([
                'fullname' => $value['fullname'],
                'type' => $value['type'],
                'flight_book_id' => $flightBook->id,
            ]);
        };

        return response()->json([
            'messages' => 'FlightBook created',
            'data' => new FlightBookResource($flightBook),
            'status' =>Response::HTTP_CREATED
        ], Response::HTTP_CREATED);
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\FlightBook  $flightBook
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $flightBook = FlightBook::where('id', $id)->first();
        
        if($flightBook === null) {
            return response()->json([
                'message' => 'Flight Book not found',
                'status' => Response::HTTP_NOT_FOUND
            ], Response::HTTP_NOT_FOUND);
        }

        return new FlightBookResource($flightBook);
    }
}
