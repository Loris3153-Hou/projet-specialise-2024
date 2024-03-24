<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fenetre extends Model
{
    protected $table = 'FENETRE'; // Nom de la table dans la base de données

    protected $primaryKey = 'id_fenetre';

    public $timestamps = false;

    protected $fillable = ['id_mur', 'longueur_fenetre', 'distance_fenetre'];
}