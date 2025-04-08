<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Turno extends Model
{
    //
    use HasFactory;
    //Protege contra la asignación masiva inesperada de atributos

    protected $fillable = [
        'nombre'
    ];


}
