<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Porte extends Model
{

    protected $table = 'PORTE';

    protected $primaryKey = 'id_porte';

    public $timestamps = false;

    protected $fillable = ['id_mur', 'longueur_porte', 'distance_porte'];
}