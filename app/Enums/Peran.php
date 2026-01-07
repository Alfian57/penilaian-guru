<?php

namespace App\Enums;

enum Peran: string
{
    case ADMIN = 'admin';
    case KEPSEK = 'kepsek';
    case GURU = 'guru';
    case SISWA = 'siswa';

    public function label(): string
    {
        return match ($this) {
            self::ADMIN => 'Administrator',
            self::KEPSEK => 'Kepala Sekolah',
            self::GURU => 'Guru',
            self::SISWA => 'Siswa',
        };
    }
}
