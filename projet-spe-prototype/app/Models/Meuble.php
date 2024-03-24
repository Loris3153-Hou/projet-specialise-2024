<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Meuble extends Model
{
    protected $table = 'MEUBLE'; // Nom de la table dans la base de données

    protected $primaryKey = 'id_meuble';

    public $timestamps = false;

    protected $fillable = ['id_chambre', 'largeur_meuble', 'longueur_meuble', 'hauteur_meuble', 'type_meuble'];
}