<?php

namespace App\Enums;

enum JenisPenilai: string
{
    case ATASAN = 'atasan';
    case SEJAWAT = 'sejawat';
    case SISWA = 'siswa';

    public function label(): string
    {
        return match ($this) {
            self::ATASAN => 'Atasan',
            self::SEJAWAT => 'Sejawat',
            self::SISWA => 'Siswa',
        };
    }
}
