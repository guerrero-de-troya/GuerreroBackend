<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tema extends Model
{
    use HasFactory;

    protected $table = 'temas';

    protected $fillable = [
        'name',
    ];

    public function parametros(): BelongsToMany
    {
        return $this->belongsToMany(
            Parametro::class,
            'parametros_temas',
            'tema_id',
            'parametro_id'
        )
            ->using(ParametroTema::class)
            ->withTimestamps();
    }
}
