# Laravel Application: Consuming an API and Displaying Data

## 📌 Overview
This project demonstrates how to build a Laravel application that:
- Consumes an external API
- Retrieves data using HTTP requests
- Displays the results in a Blade view

---

## ⚙️ Requirements
- PHP >= 8.x  
- Composer  
- Laravel installed  
- Internet connection (to access API)

---

## 🚀 Installation

### 1. Create a Laravel project
```bash
laravel new app
cd app

---

## Start the development server
php artisan serve

---

## 🧩 Step 1: Create a Controller

```bash
php artisan make:controller ApiController
```

---

## 🧩 Step 2: Add API Logic to the Controller

Open `app/Http/Controllers/ApiController.php` and add the following method:

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class ApiController extends Controller
{
    public function getData()
    {
        $response = Http::get('https://api.exemple.com/products');

        if ($response->successful()) {
            $data = $response->json();
            return view('products', compact('data'));
        } else {
            return "Error fetching data from API";
        }
    }
}
```

---

## 🎨 Step 3: Create a Blade View

Create a new file `resources/views/products.blade.php`:

```html
<!DOCTYPE html>
<html>
<head>
    <title>Products</title>
</head>
<body>

<h1>Product List</h1>

@foreach($data as $product)
    <div>
        <h3>{{ $product['name'] }}</h3>
        <p>Price: {{ $product['price'] }}</p>
    </div>
@endforeach

</body>
</html>
```

---

## 🌐 Step 4: Define a Route

Add this route to `app/routes/web.php`:

```php
use App\Http\Controllers\ApiController;

Route::get('/products', [ApiController::class, 'getData']);
```

---
##🧪 Example API Response

```json
[
  { "name": "Phone", "price": 2000 },
  { "name": "Laptop", "price": 5000 }
]
```

## ⚠️ Error Handling (Optional)

```php
if ($response->failed()) {
    return "API request failed";
}
```

---
## 6. Test the Application

1. Start the development server:
   ```bash
   php artisan serve
   ```

2. Open your browser and go to:
   ```
   http://localhost:8000/posts
   ```
3. You will see:
Phone - 2000
Laptop - 5000

---

## 📝 How It Works

1. **Route**: `GET /posts` triggers the `showPosts` method in `ApiController`
2. **HTTP Request**: `Http::get()` makes a request to the external API
3. **Data Processing**: The JSON response is converted to a PHP array
4. **View Rendering**: The data is passed to `posts.blade.php` for display

---

## 🔧 Customization

### Change API URL
Update the URL in `ApiController.php`:

```php
$response = Http::get('https://api.example.com/data');
```

### Add Authentication
```php
$response = Http::withToken('your-token')->get('...');
```

### Handle Errors
```php
$response = Http::get('...');

if ($response->successful()) {
    $data = $response->json();
} else {
    return 'Error fetching data';
}
```

---

## 📚 Useful Resources

- [Laravel HTTP Client Documentation](https://laravel.com/docs/http-client)
- [Laravel Routing](https://laravel.com/docs/routing)
- [Laravel Blade Templates](https://laravel.com/docs/blade)

---

⚡ *Built with Laravel — Documented by Antigravity*