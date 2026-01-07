<?php

namespace App\Models;

use App\Enums\Peran;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * @property int $id
 * @property string $nama_lengkap
 * @property string $email
 * @property string $password
 * @property Peran $peran
 * @property \Illuminate\Support\Carbon|null $dibuat_pada
 * @property \Illuminate\Support\Carbon|null $diperbarui_pada
 * @property-read Guru|null $guru
 * @property-read Penilai|null $penilai
 */
class Pengguna extends Authenticatable
{
    protected $table = 'pengguna';

    const CREATED_AT = 'dibuat_pada';
    const UPDATED_AT = 'diperbarui_pada';

    protected $fillable = [
        'nama_lengkap',
        'email',
        'password',
        'peran',
    ];

    protected $hidden = [
        'password',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'peran' => Peran::class,
            'dibuat_pada' => 'datetime',
            'diperbarui_pada' => 'datetime',
        ];
    }

    public function guru()
    {
        return $this->hasOne(Guru::class, 'pengguna_id');
    }

    public function penilai()
    {
        return $this->hasOne(Penilai::class, 'pengguna_id');
    }

    public function isAdmin(): bool
    {
        return $this->peran === Peran::ADMIN;
    }

    public function isKepsek(): bool
    {
        return $this->peran === Peran::KEPSEK;
    }

    public function isGuru(): bool
    {
        return $this->peran === Peran::GURU;
    }

    public function isSiswa(): bool
    {
        return $this->peran === Peran::SISWA;
    }
}
