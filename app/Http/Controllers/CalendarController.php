<?php

namespace App\Http\Controllers;

use App\Models\Reminder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CalendarController extends Controller
{
    public function index()
    {
        return view('empresa.calendar');
    }

    public function getReminders()
    {
        $reminders = Reminder::where('empresa_id', Auth::user()->empresa->id)
            ->get()
            ->map(function($reminder) {
                return [
                    'id' => $reminder->id,
                    'title' => $reminder->title,
                    'description' => $reminder->description,
                    'start' => $reminder->date,
                    'allDay' => true
                ];
            });

        return response()->json($reminders);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date' => 'required|date'
        ]);

        $reminder = Reminder::create([
            'empresa_id' => Auth::user()->empresa->id,
            'title' => $validated['title'],
            'description' => $validated['description'],
            'date' => $validated['date']
        ]);

        return response()->json($reminder);
    }

    public function update(Request $request, Reminder $reminder)
    {
        if ($reminder->empresa_id !== Auth::user()->empresa->id) {
            return response()->json(['error' => 'No autorizado'], 403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date' => 'required|date'
        ]);

        $reminder->update($validated);

        return response()->json($reminder);
    }

    public function destroy(Reminder $reminder)
    {
        if ($reminder->empresa_id !== Auth::user()->empresa->id) {
            return response()->json(['error' => 'No autorizado'], 403);
        }

        $reminder->delete();

        return response()->json(['message' => 'Recordatorio eliminado']);
    }
}
