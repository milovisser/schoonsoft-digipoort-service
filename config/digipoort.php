<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Digipoort Configuration
    |--------------------------------------------------------------------------
    |
    | Configuratie voor de Digipoort integratie met de Nederlandse Belastingdienst.
    | Deze configuratie bevat de endpoints en instellingen voor het versturen
    | van XBRL berichten naar Digipoort.
    |
    */

    'base_url' => env('DIGIPOORT_BASE_URL', 'https://www.digipoort.nl'),

    'api_version' => env('DIGIPOORT_API_VERSION', 'v1'),

    'timeout' => env('DIGIPOORT_TIMEOUT', 30),

    'retry_attempts' => env('DIGIPOORT_RETRY_ATTEMPTS', 3),

    'retry_delay' => env('DIGIPOORT_RETRY_DELAY', 5),

    /*
    |--------------------------------------------------------------------------
    | Certificate Settings
    |--------------------------------------------------------------------------
    |
    | Instellingen voor PKI certificaten die gebruikt worden voor authenticatie
    | en signing van berichten naar Digipoort.
    |
    */

    'certificate_storage_path' => env('DIGIPOORT_CERTIFICATE_STORAGE_PATH', 'certificates'),

    'signing_algorithm' => env('DIGIPOORT_SIGNING_ALGORITHM', 'SHA256'),
];
