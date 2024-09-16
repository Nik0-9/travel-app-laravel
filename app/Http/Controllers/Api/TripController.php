<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Trip;

class TripController extends Controller
{
    public function index()
    {
        $trips = Trip::with('days')->get();
        return response()->json([
            'status' => 'success',
            'results' => $trips
        ], 200);
    }

    public function show($id)
    {
        $trip = Trip::with('days')->findOrFail($id);
        return response()->json($trip);
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        try {
            \Log::info('Validation passed');

            $slug = Trip::generateSlug($request->name);
            \Log::info('Generated Slug: ' . $slug);
            $request->request->add(['slug' => $slug]);
            $trip = Trip::create($request->all());
            $trip->save();

            \Log::info('Trip Saved: ', $trip->toArray());

            return response()->json($trip, 201);
        } catch (\Exception $e) {
            \Log::error('Error creating trip: ' . $e->getMessage());
            return response()->json(['error' => 'Server Error'], 500);
        }
    }
    public function update(Request $request, $id)
{
    // Validare i dati in arrivo
    $request->validate([
        'end_date' => 'nullable|date|after_or_equal:start_date',
    ]);

    try {
        // Trovare il viaggio per ID
        $trip = Trip::findOrFail($id);

        // Aggiornare solo la data di fine (oppure altri campi se necessario)
        $trip->end_date = $request->input('end_date');
        $trip->save();

        // Restituire il viaggio aggiornato
        return response()->json($trip, 200);
    } catch (\Exception $e) {
        // Gestire eventuali errori
        \Log::error('Error updating trip: ' . $e->getMessage());
        return response()->json(['error' => 'Server Error'], 500);
    }
}
}