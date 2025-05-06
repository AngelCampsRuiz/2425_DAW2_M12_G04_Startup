<?php

namespace App\Http\Controllers;

use App\Models\Reminder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CalendarController extends Controller
{
    public function index()
    {
        $reminders = Reminder::where('empresa_id', Auth::user()->empresa->id)
                            ->orderBy('date', 'asc')
                            ->get();
        
        return view('empresa.calendar', compact('reminders'));
    }

    public function show(Reminder $reminder)
    {
        if ($reminder->empresa_id !== Auth::user()->empresa->id) {
            return response()->json(['error' => 'No autorizado'], 403);
        }

        return response()->json([
            'id' => $reminder->id,
            'title' => $reminder->title,
            'description' => $reminder->description,
            'date' => $reminder->date->format('Y-m-d'),
            'color' => $reminder->color
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date' => 'required|date',
            'color' => 'required|string|max:7'
        ]);

        $reminder = Reminder::create([
            'empresa_id' => Auth::user()->empresa->id,
            'title' => $validated['title'],
            'description' => $validated['description'],
            'date' => $validated['date'],
            'color' => $validated['color']
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Recordatorio creado correctamente',
            'reminder' => $reminder
        ]);
    }

    public function update(Request $request, Reminder $reminder)
    {
        if ($reminder->empresa_id !== Auth::user()->empresa->id) {
            return response()->json(['error' => 'No autorizado'], 403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date' => 'required|date',
            'color' => 'required|string|max:7'
        ]);

        $reminder->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Recordatorio actualizado correctamente',
            'reminder' => $reminder
        ]);
    }

    public function destroy(Reminder $reminder)
    {
        if ($reminder->empresa_id !== Auth::user()->empresa->id) {
            return abort(403);
        }

        $reminder->delete();

        return redirect()->route('empresa.calendar')->with('success', 'Recordatorio eliminado correctamente');
    }

    public function toggleComplete(Reminder $reminder)
    {
        if ($reminder->empresa_id !== Auth::user()->empresa->id) {
            return abort(403);
        }

        $reminder->completed = !$reminder->completed;
        $reminder->save();

        return response()->json(['success' => true, 'completed' => $reminder->completed]);
    }
}
