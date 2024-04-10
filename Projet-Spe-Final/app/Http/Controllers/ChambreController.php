<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chambre;

class ChambreController extends Controller
{
    public function creerChambre(Request $request)
    {
        // Créez une nouvelle chambre
        $chambre = new Chambre();
        $chambre->save();

        // Afficher le contenu de $chambre
       // dd($chambre);

        // Retournez la réponse JSON
        return response()->json(['message' => 'Chambre créée avec succès', 'chambre' => $chambre->id_chambre]);

    }
    

    public function chercherChambres()
    {
        $chambres = Chambre::all();
        return response()->json($chambres);
    }
}
