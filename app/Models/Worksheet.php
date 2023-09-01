<?php

namespace App\Models;

use App\Enums\WorksheetPriority;
use App\Models\Device;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Worksheet extends Model
{
    use HasFactory;

    protected $fillable = [
        'priority',
        'description',
        'due_date',
        'finish_date',
        'device_id',
        'creator_id',
        'repairer_id',
        'attachments',
        'comment',
        // ajánlat, megrendelés, számla azonosítók kellenek majd még
    ];

    protected $casts = [
        'attachments' => 'array',
        'priority' => WorksheetPriority::class
    ];

    public function device(): BelongsTo
    {
        return $this->belongsTo(Device::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function repairer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'repairer_id'); // aki karbantartó!
    }
}
