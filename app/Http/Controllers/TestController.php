<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TestController extends Controller
{
    public function showTableStructure()
    {
        $columns = DB::select('SHOW COLUMNS FROM chats');
        return response()->json($columns);
    }
} 