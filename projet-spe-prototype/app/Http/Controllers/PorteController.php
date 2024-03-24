<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Porte;

class PorteController extends Controller
{
    public function creerPorte(Request $request)
    {

        $idMur = $request->input('id_mur');
        $longueurPorte = $request->input('longueur_porte');
        $distancePorte = $request->input('distance_porte');

        $porte = new Porte();
        $porte->id_mur = $idMur;
        $porte->longueur_porte = $longueurPorte;
        $porte->distance_porte = $distancePorte;

        $porte->save();

        return response()->json(['message' => 'Porte créée avec succès', 'porte' => $porte->id_mur]);
    }

    public function chercherPortes($idMur)
    {
        $portes = Porte::where('id_mur', $idMur)->get();

        return response()->json($portes);
    }
}