<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chambre extends Model
{
    use HasFactory;

    protected $table = 'CHAMBRE';

    protected $primaryKey = 'id_chambre';

    public $timestamps = false;

    protected $fillable = [
        'nom_chambre',
    ];

    /**
     * Get the JSON representation of the model.
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'id_chambre' => $this->id_chambre,
            'nom_chambre' => $this->nom_chambre,
        ];
    }
}
