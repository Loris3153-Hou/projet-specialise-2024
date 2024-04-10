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
        $meuble->x = $request->input('x');
        $meuble->y = $request->input('y');

        $meuble->save();

        return response()->json(['message' => 'Meuble créée avec succès', 'meuble' => $meuble]);
    }

    public function chercherMeubles($chambreId)
    {
        $meubles = Meuble::where('id_chambre', $chambreId)->get();
        return response()->json($meubles);
    }

    public function updateMeuble(Request $request, $id)
    {
        $meuble = Meuble::findOrFail($id);

        $meuble->x = $request->input('x');
        $meuble->y = $request->input('y');

        $meuble->save();

        return response()->json(['message' => 'Meuble mis à jour avec succès'], 200);
    }
}