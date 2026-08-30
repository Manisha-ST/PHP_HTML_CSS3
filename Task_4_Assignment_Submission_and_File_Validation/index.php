<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Product Catalog</title>

    <link rel="stylesheet" href="style.css">
</head>

<body>

    <div class="container">

        <header>
            <h1>Product Catalog</h1>
            <p>Select a product from our catalog</p>
        </header>

        <main class="catalog-card">

            <h2>Available Products</h2>

            <form action="process.php" method="POST">

                <div class="products">

                    <label class="product">
                        <input
                            type="radio"
                            name="product"
                            value="Laptop"
                            required
                        >

                        <div class="product-content">
                            <h3>Laptop</h3>
                            <p>Price: ₹55,000</p>
                            <span>Portable computer</span>
                        </div>
                    </label>

                    <label class="product">
                        <input
                            type="radio"
                            name="product"
                            value="Smartphone"
                        >

                        <div class="product-content">
                            <h3>Smartphone</h3>
                            <p>Price: ₹25,000</p>
                            <span>Modern mobile device</span>
                        </div>
                    </label>

                    <label class="product">
                        <input
                            type="radio"
                            name="product"
                            value="Headphones"
                        >

                        <div class="product-content">
                            <h3>Headphones</h3>
                            <p>Price: ₹3,000</p>
                            <span>Wireless audio device</span>
                        </div>
                    </label>

                    <label class="product">
                        <input
                            type="radio"
                            name="product"
                            value="Smart Watch"
                        >

                        <div class="product-content">
                            <h3>Smart Watch</h3>
                            <p>Price: ₹6,500</p>
                            <span>Smart wearable device</span>
                        </div>
                    </label>

                </div>

                <button type="submit">
                    View Product
                </button>

            </form>

        </main>

    </div>

</body>

</html>