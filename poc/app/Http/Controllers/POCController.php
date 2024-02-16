<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class POCController extends Controller {
    public function ajax(Request $request): \Illuminate\Http\JsonResponse
    {
        return response()->json(['message' => 'Reponse depuis Laravel']);
    }
}

