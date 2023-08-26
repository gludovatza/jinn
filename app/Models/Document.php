<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Document extends Model
{
    use HasFactory;

    protected $fillable = ['nev', 'device_id', 'attachment'];

    public function device(): BelongsTo
    {
        return $this->belongsTo(Device::class);
    }
}
