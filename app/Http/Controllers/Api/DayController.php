<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Day;
use App\Models\Trip;

class DayController extends Controller
{

    public function index($tripId)
    {
        // Verifica se il viaggio esiste
        $trip = Trip::find($tripId);
        if (!$trip) {
            return response()->json(['error' => 'Trip not found'], 404);
        }

        // Recupera tutti i giorni associati al viaggio
        $days = Day::where('trip_id', $tripId)->get();

        return response()->json($days, 200);
    }
    public function store(Request $request, $tripId)
    {
        // Verifica se il viaggio esiste
        $trip = Trip::find($tripId);
        if (!$trip) {
            return response()->json(['error' => 'Trip not found'], 404);
        }

        // Validazione della richiesta
        $request->validate([
            'date' => 'required|date',
        ]);

        // Crea una nuova istanza di Day
        $day = new Day();
        $day->day = $request->input('date');
        $day->trip_id = $tripId;
        $day->save();

        return response()->json($day, 201);
    }

}
