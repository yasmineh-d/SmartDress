# Laravel API — Web A to Web B Documentation

Complete guide to expose an API from **Web A** (Laravel) and consume it in **Web B** (Laravel + Alpine.js + NativePHP Mobile).

---

## Table of Contents

1. [Project Overview](#1-project-overview)
2. [Web A — API Provider](#2-web-a--api-provider)
3. [Web B — Consumer Setup](#3-web-b--consumer-setup)
4. [Alpine.js Fetch (Separated JS File)](#4-alpinejs-fetch-separated-js-file)
5. [NativePHP Mobile Setup](#5-nativephp-mobile-setup)
6. [Android Emulator Fix](#6-android-emulator-fix)
7. [CORS Configuration](#7-cors-configuration)
8. [Troubleshooting](#8-troubleshooting)

---

## 1. Project Overview

```
Web A (API)          Web B (Consumer)         Mobile (NativePHP)
localhost:8000  ───► localhost:9000      ───► Android Emulator
                     Alpine.js fetch          10.0.2.2:8000
```

| App   | Role                         | Port   |
| ----- | ---------------------------- | ------ |
| Web A | Laravel API Provider         | `8000` |
| Web B | Laravel Consumer + NativePHP | `9000` |

---

## 2. Web A — API Provider

### 2.1 Enable `api.php` (Laravel 11)

Run this command first:

```bash
php artisan install:api
```

Or manually add `api.php` in `bootstrap/app.php`:

```php
return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',   // ← add this line
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->create();
```

### 2.2 Route — `routes/api.php`

```php
<?php

use App\Http\Controllers\ClientMetricsController;
use Illuminate\Support\Facades\Route;

Route::get('/client/{id}/metrics', [ClientMetricsController::class, 'show']);
```

### 2.3 Service — `app/Services/DashboardService.php`

```php
<?php
namespace App\Services;

use App\Models\Client;
use App\Models\Evolution;

class DashboardService {

    public function getClientMetrics(int $clientId)
    {
        $client = Client::with('user')->findOrFail($clientId);

        $latestEvolution = Evolution::where('client_id', $clientId)
                            ->latest()->first();

        $previousEvolution = Evolution::where('client_id', $clientId)
                            ->latest()->skip(1)->first();

        $weightChange = 0;
        if ($latestEvolution && $previousEvolution) {
            $weightChange = round($latestEvolution->weight - $previousEvolution->weight, 1);
        }

        return [
            'client_id'      => $client->id,
            'client_name'    => $client->user->name,
            'status'         => $client->status,
            'target_goal'    => $client->target_goal,
            'current_weight' => $latestEvolution?->weight ?? $client->current_weight,
            'weight_change'  => $weightChange,
            'height'         => $client->height,
        ];
    }
}
```

### 2.4 Controller — `app/Http/Controllers/ClientMetricsController.php`

```php
<?php
namespace App\Http\Controllers;

use App\Services\DashboardService;

class ClientMetricsController extends Controller
{
    public function show($id)
    {
        $service = new DashboardService();
        $data = $service->getClientMetrics($id);

        return response()->json([
            'success' => true,
            'data'    => $data
        ]);
    }
}
```

### 2.5 Test API in browser or Postman

```
GET http://localhost:8000/api/client/1/metrics
```

Expected response:

```json
{
  "success": true,
  "data": {
    "client_id": 1,
    "client_name": "Client Ahmed",
    "status": "active",
    "target_goal": 75,
    "current_weight": 83.1,
    "weight_change": -1.2,
    "height": 178
  }
}
```

### 2.6 Run Web A

```bash
php artisan serve --host=0.0.0.0 --port=8000
```

---

## 3. Web B — Consumer Setup

### 3.1 Route — `routes/web.php`

No controller needed — just pass `clientId` to the view:

```php
<?php

use Illuminate\Support\Facades\Route;

Route::get('/client/{id}/dashboard', function ($id) {
    return view('dashboard', ['clientId' => $id]);
})->name('client.dashboard');
```

### 3.2 Environment — `.env`

```env
# Use your PC local IP for real device
VITE_API_URL=http://192.168.1.10:8000/api

# OR use 10.0.2.2 for Android Studio emulator
VITE_API_URL=http://10.0.2.2:8000/api
```

> ⚠️ Always prefix with `VITE_` to expose variables to JavaScript via Vite.

### 3.3 Vite Config — `vite.config.js`

```javascript
import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
  plugins: [
    laravel({
      input: ["resources/css/app.css", "resources/js/app.js"],
      refresh: true,
    }),
  ],
});
```

### 3.4 Run Web B

```bash
php artisan serve --port=9000
npm run dev
```

Visit:

```
http://localhost:9000/client/1/dashboard
```

---

## 4. Alpine.js Fetch (Separated JS File)

### 4.1 Install Alpine via npm

```bash
npm install alpinejs
```

### 4.2 JS File — `resources/js/dashboard.js`

```javascript
const API_URL = import.meta.env.VITE_API_URL;

window.dashboardData = function (clientId) {
  return {
    metrics: null,
    loading: true,
    error: null,
    clientId: clientId,

    async fetchMetrics() {
      try {
        const res = await fetch(`${API_URL}/client/${this.clientId}/metrics`);
        const json = await res.json();

        if (json.success) {
          this.metrics = json.data;
        } else {
          this.error = "Client not found";
        }
      } catch (e) {
        this.error = "Cannot connect to API";
      } finally {
        this.loading = false;
      }
    },
  };
};
```

### 4.3 Entry Point — `resources/js/app.js`

```javascript
import Alpine from "alpinejs";
import "./dashboard.js";

window.Alpine = Alpine;
Alpine.start();
```

### 4.4 Blade View — `resources/views/dashboard.blade.php`

```html
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    @vite(['resources/js/app.js'])
    <style>
      @import url("https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;700;800&display=swap");
      body {
        font-family: "JetBrains Mono", monospace;
      }
      [x-cloak] {
        display: none !important;
      }
    </style>
  </head>
  <body x-data="dashboardData({{ $clientId }})" x-init="fetchMetrics()">
    {{-- LOADING --}}
    <div x-show="loading" x-cloak class="animate-pulse p-5">
      <div class="bg-zinc-300 h-40 w-full mb-4"></div>
      <div class="grid grid-cols-2 gap-4">
        <div class="bg-zinc-200 h-28"></div>
        <div class="bg-zinc-200 h-28"></div>
      </div>
    </div>

    {{-- ERROR --}}
    <div x-show="error && !loading" x-cloak class="bg-red-100 text-red-600 p-4">
      ⚠ <span x-text="error"></span>
    </div>

    {{-- DATA --}}
    <template x-if="metrics && !loading">
      <div>
        <p x-text="'Client: ' + metrics.client_name"></p>
        <p x-text="'Weight: ' + metrics.current_weight + ' KG'"></p>
        <p x-text="'Change: ' + metrics.weight_change + ' KG'"></p>
        <p x-text="'Height: ' + metrics.height + ' CM'"></p>
        <p x-text="'Status: ' + metrics.status"></p>
      </div>
    </template>

    <script>
      lucide.createIcons();
    </script>
  </body>
</html>
```

---

## 5. NativePHP Mobile Setup

### 5.1 Install NativePHP

```bash
composer require nativephp/mobile
php artisan native:install
```

### 5.2 Configure — `config/nativephp.php`

```php
'app_id'    => env('NATIVEPHP_APP_ID'),
'start_url' => env('NATIVEPHP_START_URL', '/client/1/dashboard'),
'version'   => env('NATIVEPHP_APP_VERSION', '1.0.0'),

'android' => [
    'gradle_jdk_path'    => env('NATIVEPHP_GRADLE_PATH'),
    'android_sdk_path'   => env('NATIVEPHP_ANDROID_SDK_LOCATION'),
],

'orientation' => [
    'android' => [
        'portrait'      => true,
        'landscape_left'  => false,
        'landscape_right' => false,
    ],
],
```

### 5.3 Environment — `.env`

```env
NATIVEPHP_APP_ID=com.yourname.dashboard
NATIVEPHP_APP_VERSION=1.0.0
NATIVEPHP_START_URL=/client/1/dashboard

# Android Studio paths (Windows)
NATIVEPHP_ANDROID_SDK_LOCATION=C:\Users\YourName\AppData\Local\Android\Sdk
NATIVEPHP_GRADLE_PATH=C:\Program Files\Android\Android Studio\jbr
```

### 5.4 Run on Android emulator

```bash
php artisan native:run android
```

### 5.5 Hot reload during development

```bash
php artisan native:serve
```

Scan the QR code with your phone or emulator.

### 5.6 Build APK

```bash
npm run build
php artisan native:build android
```

APK output location:

```
storage/app/native-build/
```

---

## 6. Android Emulator Fix

The Android Studio emulator cannot reach `localhost` on your PC directly.

| Environment             | API URL to use                 |
| ----------------------- | ------------------------------ |
| Android Studio Emulator | `http://10.0.2.2:8000/api`     |
| Real device (same WiFi) | `http://192.168.1.XX:8000/api` |
| Web browser             | `http://localhost:8000/api`    |

### Fix `.env` on Web B for emulator

```env
VITE_API_URL=http://10.0.2.2:8000/api
```

### Run Web A on all interfaces

```bash
php artisan serve --host=0.0.0.0 --port=8000
```

### Find your PC IP (for real device)

```bash
ipconfig
# Look for IPv4 Address e.g. 192.168.1.10
```

### Rebuild after `.env` change

```bash
# Always restart Vite after .env changes
npm run build
```

---

## 7. CORS Configuration

Since Alpine.js fetches from the browser directly, CORS must be enabled on **Web A**.

### `config/cors.php` on Web A

```php
<?php

return [
    'paths'               => ['api/*'],
    'allowed_origins'     => ['*'],        // or set specific: ['http://localhost:9000']
    'allowed_methods'     => ['*'],
    'allowed_headers'     => ['*'],
    'exposed_headers'     => [],
    'max_age'             => 0,
    'supports_credentials' => false,
];
```

### Clear cache after changes

```bash
php artisan config:clear
php artisan cache:clear
php artisan route:clear
```

---

## 8. Troubleshooting

### Route not found (404)

```bash
# Check routes are registered
php artisan route:list

# If api routes missing (Laravel 11) run:
php artisan install:api

# Or add to bootstrap/app.php manually:
api: __DIR__.'/../routes/api.php',
```

### Cannot connect to API on emulator

```env
# Wrong
VITE_API_URL=http://localhost:8000/api

# Correct for Android Studio emulator
VITE_API_URL=http://10.0.2.2:8000/api
```

### VITE\_ prefix rule

| Usage                          | Prefix needed           |
| ------------------------------ | ----------------------- |
| PHP `env()`                    | No prefix needed        |
| JavaScript `import.meta.env.*` | Must use `VITE_` prefix |

### Windows PowerShell — grep not found

```powershell
# Use findstr instead of grep
php artisan route:list | findstr client
```

### Vite not picking up .env changes

```bash
# Stop Vite and restart after every .env change
npm run dev
```

---

## Quick Reference

```bash
# Web A
php artisan serve --host=0.0.0.0 --port=8000

# Web B
php artisan serve --port=9000
npm run dev

# NativePHP
php artisan native:serve        # hot reload with QR code
php artisan native:run android  # run on emulator
php artisan native:build android # build APK

# Clear everything
php artisan config:clear
php artisan cache:clear
php artisan route:clear
```
