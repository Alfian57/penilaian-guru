<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property int $id
 * @property int $periode_id
 * @property int $penilai_id
 * @property int $guru_id
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $dibuat_pada
 * @property-read PeriodeAkademik $periode
 * @property-read Penilai $penilai
 * @property-read Guru $guru
 * @property-read HasilPenilaian|null $hasilPenilaian
 */
class PenugasanPenilaian extends Model
{
    protected $table = 'penugasan_penilaian';

    public $timestamps = true;

    const CREATED_AT = 'dibuat_pada';
    const UPDATED_AT = null;

    protected $fillable = [
        'periode_id',
        'penilai_id',
        'guru_id',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'dibuat_pada' => 'datetime',
        ];
    }

    public function periode()
    {
        return $this->belongsTo(PeriodeAkademik::class, 'periode_id');
    }

    public function penilai()
    {
        return $this->belongsTo(Penilai::class, 'penilai_id');
    }

    public function guru()
    {
        return $this->belongsTo(Guru::class, 'guru_id');
    }

    public function hasilPenilaian()
    {
        return $this->hasOne(HasilPenilaian::class, 'penugasan_id');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeSelesai($query)
    {
        return $query->where('status', 'selesai');
    }
}
