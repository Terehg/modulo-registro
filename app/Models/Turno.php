<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Turno extends Model
{
    //
    use HasFactory;
    //Protege tu aplicación contra la asignación masiva inesperada de atributos que no deseas que sean 
    //modificados por el usuario, lo que podría representar un riesgo de seguridad.
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre'
    ];

   
}
