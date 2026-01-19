<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tema extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'temas';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
    ];

    /**
     * Obtener los parámetros relacionados con este tema
     *
     * @return BelongsToMany<Parametro>
     */
    public function parametros(): BelongsToMany
    {
        return $this->belongsToMany(
            Parametro::class,
            'parametros_temas',
            'tema_id',
            'parametro_id'
        )->withTimestamps();
    }
}
