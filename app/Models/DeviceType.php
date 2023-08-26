<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DeviceType extends Model
{
    use HasFactory;

    protected $guard = ['id', 'created_at', 'updated_at'];

    public function devices(): HasMany
    {
        return $this->hasMany(Device::class);
    }
}
