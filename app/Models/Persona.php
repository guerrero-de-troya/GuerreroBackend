<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Persona extends Model
{
    use HasFactory;

    protected $table = 'personas';

    protected $fillable = [
        'primer_nombre',
        'segundo_nombre',
        'primer_apellido',
        'segundo_apellido',
        'tipo_documento_id',
        'numero_documento',
        'telefono',
        'edad',
        'genero_id',
        'nivel_id',
        'camisa',
        'talla_id',
        'eps_id',
        'pais_id',
        'departamento_id',
        'municipio_id',
    ];

    protected function casts(): array
    {
        return [];
    }

    protected $uppercase = [
        'primer_nombre',
        'segundo_nombre',
        'primer_apellido',
        'segundo_apellido',
        'numero_documento',
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::saving(function ($model) {
            foreach ($model->uppercase as $field) {
                if (isset($model->attributes[$field]) && is_string($model->attributes[$field])) {
                    $model->attributes[$field] = strtoupper($model->attributes[$field]);
                }
            }
        });
    }

    public function tipoDocumento(): BelongsTo
    {
        return $this->belongsTo(Parametro::class, 'tipo_documento_id');
    }

    public function genero(): BelongsTo
    {
        return $this->belongsTo(Parametro::class, 'genero_id');
    }

    public function nivel(): BelongsTo
    {
        return $this->belongsTo(Parametro::class, 'nivel_id');
    }

    public function talla(): BelongsTo
    {
        return $this->belongsTo(Parametro::class, 'talla_id');
    }

    public function eps(): BelongsTo
    {
        return $this->belongsTo(Parametro::class, 'eps_id');
    }

    public function pais(): BelongsTo
    {
        return $this->belongsTo(Pais::class, 'pais_id');
    }

    public function departamento(): BelongsTo
    {
        return $this->belongsTo(Departamento::class, 'departamento_id');
    }

    public function municipio(): BelongsTo
    {
        return $this->belongsTo(Municipio::class, 'municipio_id');
    }

    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'persona_id');
    }
}
