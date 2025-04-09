<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Subcategoria;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function getCategories()
    {
        return response()->json(Categoria::all());
    }

    public function getSubcategories($categoryId)
    {
        $subcategories = Subcategoria::where('categoria_id', $categoryId)->get();
        return response()->json($subcategories);
    }
} 