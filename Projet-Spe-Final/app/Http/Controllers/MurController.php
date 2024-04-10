<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mur;

class MurController extends Controller
{
    public function creerMur(Request $request)
    {
        $idChambre = $request->input('id_chambre');

        $mur = new Mur();
        $mur->id_chambre = $idChambre;
        $mur->num_mur = $request->input('num_mur');
        $mur->hauteur_mur = $request->input('hauteur_mur');
        $mur->longeur_mur = $request->input('longeur_mur');
        $mur->debut_x_mur = $request->input('debut_x_mur');
        $mur->debut_y_mur = $request->input('debut_y_mur');
        $mur->fin_x_mur = $request->input('fin_x_mur');
        $mur->fin_y_mur = $request->input('fin_y_mur');
        $mur->save();

        return response()->json(['message' => 'Mur créée avec succès', 'mur' => $mur->id_chambre]);

    }

    public function chercherMurs($idChambre)
    {
        $murs = Mur::where('id_chambre', $idChambre)->get();

        return response()->json($murs);
    }
}