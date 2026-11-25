<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $nama
 * @property string $deskripsi
 * @property string|null $foto
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
#[Fillable(['nama', 'deskripsi', 'foto'])]
class Biodata extends Model
{
    /**
     * Get the public URL for the biodata photo.
     */
    public function fotoUrl(): string
    {
        if (blank($this->foto)) {
            return asset('images/default-avatar.svg');
        }

        if (str_starts_with($this->foto, 'http://') || str_starts_with($this->foto, 'https://')) {
            return $this->foto;
        }

        if (str_starts_with($this->foto, 'images/')) {
            return asset($this->foto);
        }

        return asset('storage/'.$this->foto);
    }
}
