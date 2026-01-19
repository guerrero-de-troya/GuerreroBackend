<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Parametro extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'parametros';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
    ];

    /**
     * Obtener los temas relacionados con este parámetro
     *
     * @return BelongsToMany<Tema>
     */
    public function temas(): BelongsToMany
    {
        return $this->belongsToMany(
            Tema::class,
            'parametros_temas',
            'parametro_id',
            'tema_id'
        )->withTimestamps();
    }
}
