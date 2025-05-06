<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Closure;

class CalendarController extends Controller
{
    public function index()
    {
        return view('empresa.calendar');
    }

    public function getEvents()
    {
        try {
            $events = Event::where('empresa_id', auth()->user()->empresa->id)->get();
            return response()->json($events);
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => 'Error al cargar los eventos: ' . $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start' => 'required|date',
            'color' => 'nullable|string|max:7'
        ]);

        $event = Event::create([
            'empresa_id' => auth()->user()->empresa->id,
            'title' => $request->title,
            'description' => $request->description,
            'start' => $request->start,
            'color' => $request->color
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Recordatorio creado correctamente',
            'event' => $event
        ]);
    }

    public function update(Request $request, Event $event)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start' => 'required|date',
            'end' => 'nullable|date|after:start',
            'color' => 'nullable|string|max:7'
        ]);

        $event->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Evento actualizado correctamente',
            'event' => $event
        ]);
    }

    public function destroy(Event $event)
    {
        $event->delete();
        return response()->json([
            'success' => true,
            'message' => 'Evento eliminado correctamente'
        ]);
    }

    public function handle($request, Closure $next)
    {
        if (!auth()->user() || !auth()->user()->empresa) {
            return response()->json([
                'error' => true,
                'message' => 'Usuario no autorizado o empresa no encontrada'
            ], 403);
        }

        return $next($request);
    }
}
