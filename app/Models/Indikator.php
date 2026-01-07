<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property int $kriteria_id
 * @property string $pertanyaan
 * @property int $skala_maksimal
 * @property-read Kriteria $kriteria
 * @property-read Collection<int, DetailPenilaian> $detailPenilaian
 */
class Indikator extends Model
{
    protected $table = 'indikator';

    public $timestamps = false;

    protected $fillable = [
        'kriteria_id',
        'pertanyaan',
        'skala_maksimal',
    ];

    public function kriteria()
    {
        return $this->belongsTo(Kriteria::class, 'kriteria_id');
    }

    public function detailPenilaian()
    {
        return $this->hasMany(DetailPenilaian::class, 'indikator_id');
    }
}
