<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Stop;
use App\Models\Day;

class StopController extends Controller
{
    public function index($dayId, $tripId)
    {
        $day = Day::where('trip_id', $tripId)->where('id', $dayId)->first();
        if (!$day) {
            return response()->json(['error' => 'Day not found'], 404);
        }

        $stops = Stop::where('day_id', $dayId)->get();
        if ($stops->isEmpty()) {
            return response()->json(['message' => 'No stops found'], 200);
        }
        return response()->json($stops, 200);
    }

    public function store(Request $request, $dayId, $tripId)
    {
        $day = Day::where('trip_id', $tripId)->where('id', $dayId)->first();
        if (!$day) {
            return response()->json(['error' => 'Day not found'], 404);
        }

        $request->validate([
            'title' => 'required|string|max:200',
            'description' => 'nullable|string|max:500',
            'image' => 'nullable|string|max:255',
            'food' => 'nullable|string|max:150',
            'address' => 'required|string|max:255',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        $stop = new Stop();
        $stop->title = $request->input('title');
        $stop->description = $request->input('description');
        $stop->image = $request->input('image');
        $stop->food = $request->input('food');
        $stop->address = $request->input('address');
        $stop->latitude = $request->input('latitude');
        $stop->longitude = $request->input('longitude');
        $stop->day_id = $dayId;
        $stop->save();
        return response()->json($stop, 201);
    }
}
