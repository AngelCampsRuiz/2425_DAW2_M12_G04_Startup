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

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date' => 'required|date',
            'color' => 'nullable|string|max:7'
        ]);

        $reminder = Reminder::create([
            'empresa_id' => Auth::user()->empresa->id,
            'title' => $request->title,
            'description' => $request->description,
            'date' => $request->date,
            'color' => $request->color ?? '#7C3AED'
        ]);

        return redirect()->route('empresa.calendar')->with('success', 'Recordatorio creado correctamente');
    }

    public function update(Request $request, Reminder $reminder)
    {
        if ($reminder->empresa_id !== Auth::user()->empresa->id) {
            return abort(403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date' => 'required|date',
            'color' => 'nullable|string|max:7',
            'completed' => 'nullable|boolean'
        ]);

        $reminder->update($request->all());

        return redirect()->route('empresa.calendar')->with('success', 'Recordatorio actualizado correctamente');
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
