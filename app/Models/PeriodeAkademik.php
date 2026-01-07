<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $nama_periode
 * @property \Illuminate\Support\Carbon $tanggal_mulai
 * @property \Illuminate\Support\Carbon $tanggal_selesai
 * @property bool $status_aktif
 * @property-read Collection<int, PenugasanPenilaian> $penugasanPenilaian
 */
class PeriodeAkademik extends Model
{
    protected $table = 'periode_akademik';

    public $timestamps = false;

    protected $fillable = [
        'nama_periode',
        'tanggal_mulai',
        'tanggal_selesai',
        'status_aktif',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_mulai' => 'date',
            'tanggal_selesai' => 'date',
            'status_aktif' => 'boolean',
        ];
    }

    public function penugasanPenilaian()
    {
        return $this->hasMany(PenugasanPenilaian::class, 'periode_id');
    }

    public function scopeAktif($query)
    {
        return $query->where('status_aktif', true);
    }
}
