<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class POCController extends Controller {
    public function ajax(Request $request)
    {
        return 'Reponse depuis Laravel';
    }
}
