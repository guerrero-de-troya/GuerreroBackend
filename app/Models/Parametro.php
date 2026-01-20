<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Parametro extends Model
{
    use HasFactory;

    protected $table = 'parametros';

    protected $fillable = [
        'name',
    ];

    public function temas(): BelongsToMany
    {
        return $this->belongsToMany(
            Tema::class,
            'parametros_temas',
            'parametro_id',
            'tema_id'
        )
            ->using(ParametroTema::class)
            ->withTimestamps();
    }
}
