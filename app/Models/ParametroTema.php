<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ParametroTema extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'parametros_temas';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'tema_id',
        'parametro_id',
    ];

    /**
     * Obtener el tema relacionado
     *
     * @return BelongsTo<Tema, ParametroTema>
     */
    public function tema(): BelongsTo
    {
        return $this->belongsTo(Tema::class, 'tema_id');
    }

    /**
     * Obtener el parámetro relacionado
     *
     * @return BelongsTo<Parametro, ParametroTema>
     */
    public function parametro(): BelongsTo
    {
        return $this->belongsTo(Parametro::class, 'parametro_id');
    }
}
