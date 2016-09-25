<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Institucion extends Model
{
    protected $table = 'institucion';

    protected $fillable = [
        'id',
        'nombre',
        'siglas',
    ];

    public $timestamps = false;

    public function sedes()
    {
        return $this->hasMany(Sede::class, 'institucion_id');
    }

    public function facultades()
    {
        return $this->hasMany(Facultad::class, 'institucion_id');
    }
}