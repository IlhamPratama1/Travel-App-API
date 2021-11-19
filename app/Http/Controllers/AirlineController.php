<?php

namespace App\Http\Controllers;

use App\Http\Requests\AirlineRequest;
use App\Models\Airline;
use Symfony\Component\HttpFoundation\Response;

class AirlineController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Airline::paginate(5);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AirlineRequest $request)
    {
        $request->validated();
        
        $newImageName = time() . '-' . $request->name . '.' . $request->image->extension();
        $request->image->move(public_path('images'), $newImageName);

        $airline = Airline::create([
            'name' => $request->name,
            'city' => $request->city,
            'image_path' => $newImageName
        ]);
        
        return response()->json([
            'data' => $airline,
            'status' =>Response::HTTP_CREATED
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Airline  $airline
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $airline = Airline::where('id', $id)->first();
        
        if($airline === null) {
            return response()->json([
                'message' => 'Airline not found',
                'status' => Response::HTTP_NOT_FOUND
            ], Response::HTTP_NOT_FOUND);
        }

        return $airline;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Airline  $airline
     * @return \Illuminate\Http\Response
     */
    public function update(AirlineRequest $request, $id)
    {
        $airline = Airline::where('id', $id)->first();

        if ($airline === null) {
            return response()->json([
                'message' => 'Airline not found',
                'status' => Response::HTTP_NOT_FOUND
            ], Response::HTTP_NOT_FOUND);
        }

        $request->validated();
        
        $newImageName = time() . '-' . $request->name . '.' . $request->image->extension();
        if ($airline->image_path !== $newImageName) {
            unlink("images/".$airline->image_path);
            $request->image->move(public_path('images'), $newImageName);
        }
        
        $airline->update([
            'name' => $request->name,
            'city' => $request->city,
            'image_path' => $newImageName
        ]);

        return response()->json([
            'message' => 'Airline updated',
            'status' => Response::HTTP_OK
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Airline  $airline
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $airline = Airline::where('id', $id)->first();

        if ($airline === null) {
            return response()->json([
                'message' => 'Airline already deleted',
                'status' => Response::HTTP_OK
            ], Response::HTTP_OK);
        }

        unlink("images/".$airline->image_path);
        $airline->delete();

        return response()->json([
            'message' => 'Airline deleted',
            'status' => Response::HTTP_OK
        ], Response::HTTP_OK);
    }
}
