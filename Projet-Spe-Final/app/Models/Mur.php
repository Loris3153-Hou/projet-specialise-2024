<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mur extends Model
{
    protected $table = 'MUR';

    protected $primaryKey = 'id_mur';

    public $timestamps = false;

    protected $fillable = [
        'id_mur',
        'id_chambre',
        'num_mur',
        'hauteur_mur',
        'longeur_mur',
        'debut_x_mur',
        'debut_y_mur',
        'fin_x_mur',
        'fin_y_mur',
    ];

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