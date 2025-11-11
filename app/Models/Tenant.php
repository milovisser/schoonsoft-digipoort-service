<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Tenant extends Model
{
    /** @use HasFactory<\Database\Factories\TenantFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'identifier',
        'api_key',
        'is_active',
        'settings',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'settings' => 'array',
        ];
    }

    public function xbrlMessages(): HasMany
    {
        return $this->hasMany(XbrlMessage::class);
    }

    public function pkiCertificates(): HasMany
    {
        return $this->hasMany(PkiCertificate::class);
    }

    public function defaultPkiCertificate(): ?PkiCertificate
    {
        return $this->pkiCertificates()
            ->where('is_active', true)
            ->where('is_default', true)
            ->first();
    }

    public static function generateApiKey(): string
    {
        return 'sk_' . Str::random(48);
    }
}
