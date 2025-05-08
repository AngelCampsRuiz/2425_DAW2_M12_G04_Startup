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

    public function update(Request $request, $id)
    {
        try {
            $reminder = Reminder::findOrFail($id);
            $reminder->update([
                'title' => $request->title,
                'description' => $request->description,
                'date' => $request->date
            ]);
            return response()->json($reminder);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $reminder = Reminder::findOrFail($id);
            $reminder->delete();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
