# Schoonsoft Digitpoort Service

Dit is een Laravel applicatie dit de digipoort commiunicatie van en naar de belastingdienst regelt.

## Vereisten

- PHP >= 8.2
- Composer
- Node.js en NPM
- MySql

## Installatie

1. Clone de repository:
```bash
git clone <repository-url>
cd schoonsoft-digipoort-service
```

2. Installeer PHP dependencies:
```bash
composer install
```

3. Kopieer het environment bestand:
```bash
cp .env.example .env
```

4. Genereer de applicatie key:
```bash
php artisan key:generate
```

5. Installeer NPM dependencies:
```bash
npm install
```

6. Bouw de frontend assets:
```bash
npm run build
```

7. Voer de migraties uit:
```bash
php artisan migrate
```

## Development

Start de development server met alle benodigde services:

```bash
composer run dev
```

Dit start automatisch:
- Laravel development server
- Queue worker
- Pail (log viewer)
- Vite development server

Of start individueel:

```bash
php artisan serve
npm run dev
```

## Testing

Voer de tests uit met:

```bash
php artisan test
```

Of gebruik Pest direct:

```bash
vendor/bin/pest
```

## Code Style

Format de code met Laravel Pint:

```bash
vendor/bin/pint
```

## Stack

- **Laravel 12** - PHP Framework
- **Livewire 3** - Full-stack framework
- **Livewire Volt** - Single-file components
- **Livewire Flux UI** - UI component library
- **Laravel Fortify** - Authentication backend
- **Tailwind CSS v4** - Utility-first CSS framework
- **Pest** - Testing framework
- **Vite** - Frontend build tool

## Licentie

Deze gehele applicatie is copyright van Milo Visser.

