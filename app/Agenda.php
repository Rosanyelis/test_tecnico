<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Agenda extends Model
{
    
    protected $primaryKey = 'id_agenda';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_agenda', 'nombre_materia', 'docente', 'tipo_materia',
    ];

    

}
