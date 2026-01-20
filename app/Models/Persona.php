<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Persona extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'personas';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
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
        'categoria_id',
        'camisa',
        'talla_id',
        'ciudad_origen_id',
        'eps_id',
        'pais_id',
        'departamento_id',
        'municipio_id',
        'is_system',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_system' => 'boolean',
        ];
    }

    protected $uppercase = [
        'primer_nombre',
        'segundo_nombre',
        'primer_apellido',
        'segundo_apellido',
        'numero_documento',
    ];

    /**
     * Boot del modelo
     */
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

    /**
     * Obtener el tipo de documento relacionado
     *
     * @return BelongsTo<ParametroTema, Persona>
     */
    public function tipoDocumento(): BelongsTo
    {
        return $this->belongsTo(ParametroTema::class, 'tipo_documento_id');
    }

    /**
     * Obtener el género relacionado
     *
     * @return BelongsTo<ParametroTema, Persona>
     */
    public function genero(): BelongsTo
    {
        return $this->belongsTo(ParametroTema::class, 'genero_id');
    }

    /**
     * Obtener la categoría relacionada
     *
     * @return BelongsTo<ParametroTema, Persona>
     */
    public function categoria(): BelongsTo
    {
        return $this->belongsTo(ParametroTema::class, 'categoria_id');
    }

    /**
     * Obtener la talla relacionada
     *
     * @return BelongsTo<ParametroTema, Persona>
     */
    public function talla(): BelongsTo
    {
        return $this->belongsTo(ParametroTema::class, 'talla_id');
    }

    /**
     * Obtener la ciudad de origen relacionada
     *
     * @return BelongsTo<ParametroTema, Persona>
     */
    public function ciudadOrigen(): BelongsTo
    {
        return $this->belongsTo(ParametroTema::class, 'ciudad_origen_id');
    }

    /**
     * Obtener la EPS relacionada
     *
     * @return BelongsTo<ParametroTema, Persona>
     */
    public function eps(): BelongsTo
    {
        return $this->belongsTo(ParametroTema::class, 'eps_id');
    }

    /**
     * Obtener el país relacionado
     *
     * @return BelongsTo<Pais, Persona>
     */
    public function pais(): BelongsTo
    {
        return $this->belongsTo(Pais::class, 'pais_id');
    }

    /**
     * Obtener el departamento relacionado
     *
     * @return BelongsTo<Departamento, Persona>
     */
    public function departamento(): BelongsTo
    {
        return $this->belongsTo(Departamento::class, 'departamento_id');
    }

    /**
     * Obtener el municipio relacionado
     *
     * @return BelongsTo<Municipio, Persona>
     */
    public function municipio(): BelongsTo
    {
        return $this->belongsTo(Municipio::class, 'municipio_id');
    }

    /**
     * Obtener el usuario relacionado
     *
     * @return HasOne<User>
     */
    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'persona_id');
    }
}
