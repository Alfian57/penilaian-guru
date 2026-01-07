<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $nama_kriteria
 * @property float $bobot_persen
 * @property-read Collection<int, Indikator> $indikator
 */
class Kriteria extends Model
{
    protected $table = 'kriteria';

    public $timestamps = false;

    protected $fillable = [
        'nama_kriteria',
        'bobot_persen',
    ];

    protected function casts(): array
    {
        return [
            'bobot_persen' => 'decimal:2',
        ];
    }

    public function indikator()
    {
        return $this->hasMany(Indikator::class, 'kriteria_id');
    }
}
