<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Meuble;

class MeubleController extends Controller
{
    public function creerMeuble(Request $request)
    {

        $meuble = new Meuble();
        $meuble->id_chambre = $request->input('id_chambre');
        $meuble->largeur_meuble = $request->input('largeur_meuble');
        $meuble->longueur_meuble = $request->input('longueur_meuble');
        $meuble->hauteur_meuble = $request->input('hauteur_meuble');
        $meuble->type_meuble = $request->input('type_meuble');

        $meuble->save();

        return response()->json(['message' => 'Fenêtre créée avec succès', 'meuble' => $meuble]);
    }

    public function chercherMeubles($chambreId)
    {
        $meubles = Meuble::where('id_chambre', $chambreId)->get();
        return response()->json($meubles);
    }
}