<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property int $penugasan_id
 * @property float $total_skor
 * @property string|null $saran_masukan
 * @property \Illuminate\Support\Carbon|null $waktu_submit
 * @property-read PenugasanPenilaian $penugasan
 * @property-read Collection<int, DetailPenilaian> $detailPenilaian
 */
class HasilPenilaian extends Model
{
    protected $table = 'hasil_penilaian';

    public $timestamps = true;

    const CREATED_AT = 'waktu_submit';
    const UPDATED_AT = null;

    protected $fillable = [
        'penugasan_id',
        'total_skor',
        'saran_masukan',
        'waktu_submit',
    ];

    protected function casts(): array
    {
        return [
            'total_skor' => 'decimal:2',
            'waktu_submit' => 'datetime',
        ];
    }

    public function penugasan()
    {
        return $this->belongsTo(PenugasanPenilaian::class, 'penugasan_id');
    }

    public function detailPenilaian()
    {
        return $this->hasMany(DetailPenilaian::class, 'hasil_id');
    }
}
