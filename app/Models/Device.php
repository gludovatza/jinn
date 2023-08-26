<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    use HasFactory;

    protected $fillable = [
        'nev',
        'bpkod',
        'type_id',
        'movexkod',
        'uzem',
        'uzemterulet',
        'aktiv',
        'tortenet',
        'megjegyzes'
    ];

    public function type(): BelongsTo
    {
        return $this->belongsTo(DeviceType::class);
    }

    public function documents(): HasMany
    {
        return $this->hasMany(Document::class);
    }
}
