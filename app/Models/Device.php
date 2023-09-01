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

    protected $casts = [
        'aktiv' => 'boolean',
    ];

    public function type(): BelongsTo
    {
        return $this->belongsTo(DeviceType::class, 'type_id');
    }

    public function documents(): HasMany
    {
        return $this->hasMany(Document::class);
    }

    public function worksheets(): HasMany
    {
        return $this->hasMany(Worksheet::class);
    }
}
