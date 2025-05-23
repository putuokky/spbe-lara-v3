<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Katserver extends Model
{
    use HasFactory;

    protected $fillable = [
        'kategori_server',
    ];

    public function applications(): HasMany
    {
        return $this->hasMany(Application::class);
    }
}
