<?php

namespace App\Http\Controllers;

use App\Models\GameScore;
use Illuminate\Http\Request;

class ErrorController extends Controller
{
    /**
     * Display the custom 404 page.
     *
     * @return \Illuminate\Http\Response
     */
    public function notFound()
    {
        $topScores = GameScore::orderBy('score', 'desc')
            ->take(10)
            ->get();
            
        return response()->view('errors.404', [
            'topScores' => $topScores
        ], 404);
    }
} 