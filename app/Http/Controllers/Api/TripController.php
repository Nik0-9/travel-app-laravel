<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Trip;

class TripController extends Controller
{
    public function index(){
        $trips = Trip::all();
        dd('trips');
        return response()->json([
            'status' => 'success',
            'results' => $trips
        ], 200);
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'slug' => 'required|string|max:150',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $slug = Trip::generateSlug($request->name);
        $trip = Trip::create($request->all());
        $trip->slug = $slug;
        $trip->save();
        return response()->json($trip, 201);
    }
}
