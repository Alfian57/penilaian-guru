<?php

namespace App\Models;

use App\Enums\JenisPenilai;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property int $pengguna_id
 * @property JenisPenilai $jenis_penilai
 * @property-read Pengguna $pengguna
 * @property-read Collection<int, PenugasanPenilaian> $penugasanPenilaian
 */
class Penilai extends Model
{
    protected $table = 'penilai';

    public $timestamps = false;

    protected $fillable = [
        'pengguna_id',
        'jenis_penilai',
    ];

    protected function casts(): array
    {
        return [
            'jenis_penilai' => JenisPenilai::class,
        ];
    }

    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'pengguna_id');
    }

    public function penugasanPenilaian()
    {
        return $this->hasMany(PenugasanPenilaian::class, 'penilai_id');
    }
}
