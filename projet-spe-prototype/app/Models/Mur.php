<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mur extends Model
{
    protected $table = 'MUR'; // Nom de la table dans la base de données

    protected $primaryKey = 'id_mur';

    public $timestamps = false;

    protected $fillable = [
        'id_mur',
        'id_chambre', // Clé étrangère faisant référence à la chambre à laquelle ce mur appartient
        'num_mur', // Numéro du mur dans la chambre
        'hauteur_mur', // Hauteur du mur
        'longeur_mur', // Longueur du mur
        'debut_x_mur', // Coordonnée x de départ
        'debut_y_mur', // Coordonnée y de départ
        'fin_x_mur',   // Coordonnée x d'arrivée
        'fin_y_mur',   // Coordonnée y d'arrivée
    ];

    // Si vous avez besoin de définir des relations avec d'autres modèles, vous pouvez le faire ici

    public function chambre()
    {
        return $this->belongsTo('App\Models\Chambre', 'id_chambre', 'id');
    }

    public function toArray()
    {
        return [
            'id_mur' => $this->id_mur,
            'id_chambre' => $this->id_chambre,
            'num_mur' => $this->num_mur,
            'hauteur_mur' => $this->hauteur_mur,
            'longeur_mur' => $this->longeur_mur,
            'debut_x_mur' => $this->debut_x_mur,
            'debut_y_mur' => $this->debut_y_mur,
            'fin_x_mur' => $this->fin_x_mur,
            'fin_y_mur' => $this->fin_y_mur,
        ];
    }
}