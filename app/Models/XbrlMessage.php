<?php

namespace App\Models;

use App\XbrlMessageStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class XbrlMessage extends Model
{
    protected $fillable = [
        'user_id',
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

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    protected function casts(): array
    {
        return [
            'message_status' => XbrlMessageStatus::class,
            'sent_at' => 'datetime',
            'processed_at' => 'datetime',
        ];
    }

    public function getStatusAttribute(): string
    {
        return $this->message_status->value;
    }
}
