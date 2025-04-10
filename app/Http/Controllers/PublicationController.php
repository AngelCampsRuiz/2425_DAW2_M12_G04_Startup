<?php

namespace App\Http\Controllers;

use App\Models\Publication;
use Illuminate\Http\Request;

class PublicationController extends Controller
{
    public function show($id)
    {
        $publication = Publication::with(['empresa', 'categoria', 'subcategoria'])->findOrFail($id);
        return view('publication.show', compact('publication'));
    }
} 