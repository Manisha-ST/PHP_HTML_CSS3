<?php

session_start();

// Product information
$products = [
    "Laptop" => [
        "price" => 55000,
        "description" => "Portable computer suitable for study and work."
    ],

    "Smartphone" => [
        "price" => 25000,
        "description" => "Modern smartphone with useful digital features."
    ],

    "Headphones" => [
        "price" => 3000,
        "description" => "Wireless headphones for music and entertainment."
    ],

    "Smart Watch" => [
        "price" => 6500,
        "description" => "Smart wearable device for everyday activities."
    ]
];

// Check form submission
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: index.php");
    exit();
}

$productName = trim($_POST["product"] ?? "");

// Validate selected product
if ($productName === "" || !isset($products[$productName])) {
    die("Invalid product selection.");
}

// Store selected product in session
$_SESSION["selected_product"] = $productName;

$productPrice = $products[$productName]["price"];
$productDescription = $products[$productName]["description"];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Product Details</title>

    <link rel="stylesheet" href="style.css">
</head>

<body>

    <div class="container">

        <header>
            <h1>Product Details</h1>
            <p>Your selected product</p>
        </header>

        <main class="result-card">

            <div class="success-message">
                Product selected successfully!
            </div>

            <div class="product-detail">

                <div class="icon">
                    🛍️
                </div>

                <h2>
                    <?= htmlspecialchars($productName) ?>
                </h2>

                <p class="description">
                    <?= htmlspecialchars($productDescription) ?>
                </p>

                <div class="price">
                    ₹<?= number_format($productPrice) ?>
                </div>

            </div>

            <div class="session-info">
                <strong>
                    Selected Product:
                </strong>

                <?= htmlspecialchars($_SESSION["selected_product"]) ?>
            </div>

            <a href="index.php" class="back-button">
                Back to Catalog
            </a>

        </main>

    </div>

</body>

</html>