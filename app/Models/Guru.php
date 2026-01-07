<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property int $pengguna_id
 * @property string|null $nip
 * @property string|null $jabatan
 * @property string|null $mata_pelajaran
 * @property-read Pengguna $pengguna
 * @property-read Collection<int, PenugasanPenilaian> $penugasanPenilaian
 * @property-read Collection<int, PenugasanPenilaian> $penugasanSebagaiDinilai
 */
class Guru extends Model
{
    protected $table = 'guru';

    public $timestamps = false;

    protected $fillable = [
        'pengguna_id',
        'nip',
        'jabatan',
        'mata_pelajaran',
    ];

    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'pengguna_id');
    }

    public function penugasanPenilaian()
    {
        return $this->hasMany(PenugasanPenilaian::class, 'guru_id');
    }

    /**
     * Alias untuk penugasanPenilaian - digunakan di laporan
     */
    public function penugasanSebagaiDinilai()
    {
        return $this->hasMany(PenugasanPenilaian::class, 'guru_id');
    }
}
