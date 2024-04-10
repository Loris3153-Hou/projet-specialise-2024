<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Fenetre;

class FenetreController extends Controller
{
    public function creerFenetre(Request $request)
    {
        $idMur = $request->input('id_mur');
        $longueurFenetre = $request->input('longueur_fenetre');
        $distanceFenetre = $request->input('distance_fenetre');


        $fenetre = new Fenetre();
        $fenetre->id_mur = $idMur;
        $fenetre->longueur_fenetre = $longueurFenetre;
        $fenetre->distance_fenetre = $distanceFenetre;

        $fenetre->save();

        return response()->json(['message' => 'Fenêtre créée avec succès', 'fenetre' => $fenetre]);
    }

    public function chercherFenetres($idMur)
    {
        $fenetres = Fenetre::where('id_mur', $idMur)->get();

        return response()->json($fenetres);
    }
}