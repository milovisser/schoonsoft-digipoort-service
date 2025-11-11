<?php

namespace App\Services;

use App\Models\PkiCertificate;
use App\Models\Tenant;
use OpenSSLAsymmetricKey;
use OpenSSLCertificate;

class PkiCertificateService
{
    public function getCertificateForTenant(Tenant $tenant): ?PkiCertificate
    {
        return $tenant->defaultPkiCertificate() ?? $tenant->pkiCertificates()
            ->where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->first();
    }

    public function loadCertificate(PkiCertificate $certificate): ?OpenSSLCertificate
    {
        if ( ! $certificate->isValid()) {
            return null;
        }

        $certContent = $certificate->certificate_content;
        $cert = openssl_x509_read($certContent);

        if ($cert === false) {
            return null;
        }

        return $cert;
    }

    public function loadPrivateKey(PkiCertificate $certificate): ?OpenSSLAsymmetricKey
    {
        if ( ! $certificate->isValid()) {
            return null;
        }

        if ( ! $certificate->private_key) {
            return null;
        }

        $privateKey = openssl_pkey_get_private(
            $certificate->private_key,
            $certificate->certificate_password
        );

        if ($privateKey === false) {
            return null;
        }

        return $privateKey;
    }

    public function signData(string $data, PkiCertificate $certificate): ?string
    {
        $privateKey = $this->loadPrivateKey($certificate);

        if ( ! $privateKey) {
            return null;
        }

        $signature = '';
        $success = openssl_sign($data, $signature, $privateKey, OPENSSL_ALGO_SHA256);

        if ( ! $success) {
            return null;
        }

        return base64_encode($signature);
    }

    public function verifySignature(string $data, string $signature, PkiCertificate $certificate): bool
    {
        $cert = $this->loadCertificate($certificate);

        if ( ! $cert) {
            return false;
        }

        $publicKey = openssl_pkey_get_public($cert);
        if ($publicKey === false) {
            return false;
        }

        $decodedSignature = base64_decode($signature, true);
        if ($decodedSignature === false) {
            return false;
        }

        $result = openssl_verify($data, $decodedSignature, $publicKey, OPENSSL_ALGO_SHA256);

        return $result === 1;
    }

    public function getCertificateInfo(PkiCertificate $certificate): ?array
    {
        $cert = $this->loadCertificate($certificate);

        if ( ! $cert) {
            return null;
        }

        $info = openssl_x509_parse($cert, false);

        return $info ?: null;
    }

    public function validateCertificate(PkiCertificate $certificate): array
    {
        $errors = [];

        if ( ! $certificate->isValid()) {
            $errors[] = 'Certificaat is niet actief of buiten geldigheidsperiode';
        }

        $cert = $this->loadCertificate($certificate);
        if ( ! $cert) {
            $errors[] = 'Certificaat kan niet worden geladen of is ongeldig';
        } else {
            $info = openssl_x509_parse($cert, false);
            if ( ! $info) {
                $errors[] = 'Certificaat informatie kan niet worden opgehaald';
            }
        }

        if ($certificate->private_key) {
            $privateKey = $this->loadPrivateKey($certificate);
            if ( ! $privateKey) {
                $errors[] = 'Private key kan niet worden geladen of wachtwoord is onjuist';
            }
        }

        return [
            'valid' => empty($errors),
            'errors' => $errors,
        ];
    }
}
