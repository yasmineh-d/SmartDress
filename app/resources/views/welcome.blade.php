<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Premium Products</title>
    <!-- Modern Typography -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-bg: #0f172a;
            --surface: #1e293b;
            --surface-hover: #334155;
            --text-main: #f8fafc;
            --text-muted: #94a3b8;
            --accent: #3b82f6;
            --accent-hover: #60a5fa;
            --error: #ef4444;
            --border: rgba(255, 255, 255, 0.1);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--primary-bg);
            color: var(--text-main);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 40px 20px;
        }

        header {
            text-align: center;
            margin-bottom: 50px;
        }

        h1 {
            font-size: 3rem;
            font-weight: 700;
            letter-spacing: -1px;
            background: linear-gradient(135deg, #60a5fa, #a78bfa);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 10px;
        }

        .subtitle {
            color: var(--text-muted);
            font-size: 1.1rem;
            max-width: 600px;
            margin: 0 auto;
        }

        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 30px;
            width: 100%;
            max-width: 1200px;
        }

        .product-card {
            background-color: var(--surface);
            border: 1px solid var(--border);
            border-radius: 16px;
            overflow: hidden;
            transition: transform 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275), box-shadow 0.3s ease;
            display: flex;
            flex-direction: column;
            position: relative;
            backdrop-filter: blur(10px);
        }

        .product-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.3), 0 10px 10px -5px rgba(0, 0, 0, 0.2);
            border-color: rgba(255, 255, 255, 0.2);
        }

        .image-container {
            width: 100%;
            height: 250px;
            background-color: white;
            padding: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .product-image {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
            transition: transform 0.5s ease;
        }

        .product-card:hover .product-image {
            transform: scale(1.08);
        }

        .product-info {
            padding: 24px;
            display: flex;
            flex-direction: column;
            flex-grow: 1;
        }

        .product-title {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 12px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            line-height: 1.4;
        }

        .product-footer {
            margin-top: auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 16px;
            border-top: 1px solid var(--border);
        }

        .product-price {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--accent-hover);
        }

        .btn-view {
            background-color: rgba(59, 130, 246, 0.1);
            color: var(--accent-hover);
            border: 1px solid var(--accent);
            padding: 8px 16px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.9rem;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .btn-view:hover {
            background-color: var(--accent);
            color: white;
        }

        .error-message {
            background-color: rgba(239, 68, 68, 0.1);
            border: 1px solid var(--error);
            color: #fca5a5;
            padding: 16px 24px;
            border-radius: 8px;
            font-weight: 500;
        }

        .empty-state {
            color: var(--text-muted);
            font-size: 1.2rem;
            text-align: center;
            padding: 40px;
        }
        
        /* Category Badge */
        .category-badge {
            position: absolute;
            top: 12px;
            right: 12px;
            background: rgba(15, 23, 42, 0.8);
            color: white;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: capitalize;
            backdrop-filter: blur(4px);
        }
    </style>
</head>

<body>

    <header>
        <h1>Our Collection</h1>
        <p class="subtitle">Discover premium products curated just for you. Quality materials and exceptional craftsmanship in every piece.</p>
    </header>

    @if($error)
        <div class="error-message">{{ $error }}</div>
    @elseif(count($data) > 0)
        <div class="product-grid">
            @foreach($data as $product)
                <div class="product-card">
                    <span class="category-badge">{{ $product['category'] ?? 'Product' }}</span>
                    <div class="image-container">
                        <img src="{{ $product['image'] }}" alt="{{ $product['title'] }}" class="product-image" loading="lazy">
                    </div>
                    <div class="product-info">
                        <h3 class="product-title">{{ $product['title'] }}</h3>
                        <div class="product-footer">
                            <span class="product-price">{{ number_format($product['price'], 2) }} €</span>
                            <button class="btn-view">Details</button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="empty-state">Aucun produit disponible.</div>
    @endif

</body>

</html>