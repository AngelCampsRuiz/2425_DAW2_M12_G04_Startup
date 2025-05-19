<?php

namespace App\Http\Controllers;

use App\Models\GameScore;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class GameScoreController extends Controller
{
    /**
     * Display the 404 page with top scores.
     *
     * @return \Illuminate\Http\Response
     */
    public function showErrorPage()
    {
        $topScores = GameScore::orderBy('score', 'desc')
            ->take(10)
            ->get();
            
        return response()->view('errors.404', [
            'topScores' => $topScores
        ], 404);
    }
    
    /**
     * Display the ranking page.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRanking()
    {
        $topScores = GameScore::orderBy('score', 'desc')
            ->take(50)
            ->get();
            
        $bestPlayers = GameScore::select('player_name')
            ->selectRaw('MAX(score) as max_score')
            ->selectRaw('SUM(obstacles_avoided) as total_obstacles')
            ->selectRaw('COUNT(*) as games_played')
            ->groupBy('player_name')
            ->orderBy('max_score', 'desc')
            ->take(10)
            ->get();
            
        $recentScores = GameScore::orderBy('created_at', 'desc')
            ->take(10)
            ->get();
            
        return view('game.ranking', [
            'topScores' => $topScores,
            'bestPlayers' => $bestPlayers,
            'recentScores' => $recentScores
        ]);
    }
    
    /**
     * Save a score using GET method (to bypass CSRF)
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function saveScore(Request $request)
    {
        try {
            Log::info('GameScore - Recibida solicitud de guardar puntuación (GET)', [
                'data' => $request->all()
            ]);
            
            // Validación manual
            $validator = Validator::make($request->all(), [
                'player_name' => 'required|string|max:255',
                'score' => 'required|integer',
                'obstacles_avoided' => 'required|integer',
            ]);
            
            if ($validator->fails()) {
                return redirect()->route('game.error-page')
                    ->with('error', 'Por favor, completa todos los campos correctamente');
            }
            
            $gameScore = GameScore::create([
                'player_name' => $request->player_name,
                'score' => $request->score,
                'obstacles_avoided' => $request->obstacles_avoided
            ]);
            
            Log::info('GameScore - Puntuación guardada correctamente (GET)', [
                'id' => $gameScore->id,
                'player' => $gameScore->player_name,
                'score' => $gameScore->score
            ]);
            
            return redirect()->route('game.error-page')
                ->with('success', 'Puntuación guardada correctamente');
                
        } catch (\Exception $e) {
            Log::error('Error al guardar puntuación (GET): ' . $e->getMessage(), [
                'exception' => $e,
                'request' => $request->all()
            ]);
            
            return redirect()->route('game.error-page')
                ->with('error', 'Error al guardar la puntuación. Inténtalo de nuevo.');
        }
    }
    
    /**
     * Store a new game score.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            Log::info('GameScore - Recibida solicitud de guardar puntuación', [
                'data' => $request->all()
            ]);
            
            // Validación manual para mayor control
            $validator = Validator::make($request->all(), [
                'player_name' => 'required|string|max:255',
                'score' => 'required|integer',
                'obstacles_avoided' => 'required|integer',
            ]);
            
            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }
            
            $validated = $validator->validated();
            
            $gameScore = GameScore::create($validated);
            
            Log::info('GameScore - Puntuación guardada correctamente', [
                'id' => $gameScore->id,
                'player' => $gameScore->player_name,
                'score' => $gameScore->score
            ]);

            // Si la solicitud espera JSON (es una API)
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Puntuación guardada correctamente',
                    'data' => $gameScore
                ]);
            }
            
            // Si es una solicitud de formulario normal, redirigir a la página 404
            return redirect()->route('game.error-page')
                ->with('success', 'Puntuación guardada correctamente');
        } catch (\Exception $e) {
            Log::error('Error al guardar puntuación: ' . $e->getMessage(), [
                'exception' => $e,
                'request' => $request->all()
            ]);
            
            // Si la solicitud espera JSON (es una API)
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al guardar la puntuación: ' . $e->getMessage()
                ], 500);
            }
            
            // Si es una solicitud de formulario normal, redirigir a la página 404 con error
            return redirect()->back()
                ->with('error', 'Error al guardar la puntuación. Inténtalo de nuevo.');
        }
    }

    /**
     * Get top 10 scores.
     *
     * @return \Illuminate\Http\Response
     */
    public function getTopScores()
    {
        try {
            $topScores = GameScore::orderBy('score', 'desc')
                ->take(10)
                ->get();

            return response()->json($topScores);
        } catch (\Exception $e) {
            Log::error('Error al obtener puntuaciones: ' . $e->getMessage(), [
                'exception' => $e
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener las puntuaciones'
            ], 500);
        }
    }
} 