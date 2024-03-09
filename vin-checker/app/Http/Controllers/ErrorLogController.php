<?php

namespace App\Http\Controllers;

use App\Models\Log;
use Illuminate\Http\Request;

class ErrorLogController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'error' => 'required',
            'page' => 'required',
        ]);

        Log::create([
            'message' => $request->input('error'),
            'page' => $request->input('page'),
        ]);

        return response()->json(['message' => 'Error logged successfully'], 200);
    }
}