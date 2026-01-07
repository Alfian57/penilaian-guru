<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $hasil_id
 * @property int $indikator_id
 * @property int $nilai
 * @property-read HasilPenilaian $hasilPenilaian
 * @property-read Indikator $indikator
 */
class DetailPenilaian extends Model
{
    protected $table = 'detail_penilaian';

    public $timestamps = false;

    protected $fillable = [
        'hasil_id',
        'indikator_id',
        'nilai',
    ];

    public function hasilPenilaian()
    {
        return $this->belongsTo(HasilPenilaian::class, 'hasil_id');
    }

    public function indikator()
    {
        return $this->belongsTo(Indikator::class, 'indikator_id');
    }
}
