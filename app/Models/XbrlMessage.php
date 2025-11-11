<?php

namespace App\Models;

use App\XbrlMessageStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class XbrlMessage extends Model
{
    protected $fillable = [
        'tenant_id',
        'message_uuid',
        'message_type',
        'message_status',
        'message_content',
        'digipoort_message_id',
        'digipoort_response',
        'sent_at',
        'processed_at',
        'error_message',
    ];

    protected function casts(): array
    {
        return [
            'message_status' => XbrlMessageStatus::class,
            'sent_at' => 'datetime',
            'processed_at' => 'datetime',
        ];
    }

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }
}
