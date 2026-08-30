<?php

session_start();

/*
 * Create empty cart and browsing history
 * if they do not already exist.
 */

if (!isset($_SESSION["cart"])) {
    $_SESSION["cart"] = [];
}

if (!isset($_SESSION["history"])) {
    $_SESSION["history"] = [];
}

/*
 * Get logged-in username from session.
 */

$loggedInUser = $_SESSION["username"] ?? "";

/*
 * Product information.
 */

$products = [
    "Laptop" => [
        "price" => 55000,
        "category" => "Electronics",
        "icon" => "💻",
        "description" => "Powerful laptop suitable for study, work and entertainment."
    ],

    "Smartphone" => [
        "price" => 25000,
        "category" => "Electronics",
        "icon" => "📱",
        "description" => "Modern smartphone with useful communication features."
    ],

    "Headphones" => [
        "price" => 3000,
        "category" => "Accessories",
        "icon" => "🎧",
        "description" => "Comfortable headphones for music and entertainment."
    ],

    "Smart Watch" => [
        "price" => 6500,
        "category" => "Wearables",
        "icon" => "⌚",
        "description" => "Smart wearable device for everyday activities."
    ],

    "Camera" => [
        "price" => 42000,
        "category" => "Electronics",
        "icon" => "📷",
        "description" => "Digital camera for capturing high-quality photographs."
    ],

    "Bluetooth Speaker" => [
        "price" => 4500,
        "category" => "Accessories",
        "icon" => "🔊",
        "description" => "Portable wireless speaker with clear sound."
    ]
];

/*
 * Calculate cart total.
 */

$cartTotal = 0;

foreach ($_SESSION["cart"] as $item) {
    $cartTotal += $item["price"];
}

$cartCount = count($_SESSION["cart"]);

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Online Shopping Management</title>

    <link rel="stylesheet" href="style.css">

</head>

<body>

<div class="container">

    <!-- HEADER -->

    <header>

        <div class="header-icon">
            🛍️
        </div>

        <h1>Online Shopping</h1>

        <p>
            Product Shopping and User Management System
        </p>

    </header>


    <!-- MAIN CONTENT -->

    <main>

        <?php if ($loggedInUser === ""): ?>

            <!-- LOGIN SECTION -->

            <section class="login-section">

                <div class="login-icon">
                    👤
                </div>

                <h2>Customer Login</h2>

                <p class="section-description">
                    Enter your username to start shopping.
                </p>

                <form action="process.php" method="POST">

                    <input
                        type="hidden"
                        name="action"
                        value="login"
                    >

                    <div class="form-group">

                        <label for="username">
                            Username
                        </label>

                        <input
                            type="text"
                            id="username"
                            name="username"
                            placeholder="Enter your username"
                            required
                        >

                    </div>

                    <button type="submit">
                        Login
                    </button>

                </form>

            </section>

        <?php else: ?>

            <!-- USER INFORMATION -->

            <section class="user-bar">

                <div>

                    <span class="small-label">
                        Logged in as
                    </span>

                    <h2>
                        👋
                        <?= htmlspecialchars($loggedInUser) ?>
                    </h2>

                </div>

                <form action="process.php" method="POST">

                    <input
                        type="hidden"
                        name="action"
                        value="logout"
                    >

                    <button
                        type="submit"
                        class="logout-button"
                    >
                        Logout
                    </button>

                </form>

            </section>


            <!-- SHOPPING STATISTICS -->

            <section class="statistics">

                <div class="stat-card">

                    <div class="stat-icon">
                        🛒
                    </div>

                    <div>
                        <span>Cart Items</span>

                        <strong>
                            <?= $cartCount ?>
                        </strong>
                    </div>

                </div>


                <div class="stat-card">

                    <div class="stat-icon">
                        💰
                    </div>

                    <div>
                        <span>Cart Value</span>

                        <strong>
                            ₹<?= number_format($cartTotal) ?>
                        </strong>
                    </div>

                </div>


                <div class="stat-card">

                    <div class="stat-icon">
                        👁️
                    </div>

                    <div>
                        <span>Products Viewed</span>

                        <strong>
                            <?= count($_SESSION["history"]) ?>
                        </strong>
                    </div>

                </div>

            </section>


            <!-- PRODUCT SECTION -->

            <section class="products-section">

                <div class="section-heading">

                    <h2>
                        🛍️ Available Products
                    </h2>

                    <p>
                        Choose products and add them to your shopping cart.
                    </p>

                </div>


                <div class="products">

                    <?php foreach ($products as $name => $product): ?>

                        <div class="product-card">

                            <div class="product-icon">
                                <?= $product["icon"] ?>
                            </div>

                            <span class="category">
                                <?= htmlspecialchars($product["category"]) ?>
                            </span>

                            <h3>
                                <?= htmlspecialchars($name) ?>
                            </h3>

                            <p class="description">
                                <?= htmlspecialchars($product["description"]) ?>
                            </p>

                            <div class="price">
                                ₹<?= number_format($product["price"]) ?>
                            </div>

                            <form
                                action="process.php"
                                method="POST"
                            >

                                <input
                                    type="hidden"
                                    name="action"
                                    value="add"
                                >

                                <input
                                    type="hidden"
                                    name="product"
                                    value="<?= htmlspecialchars($name) ?>"
                                >

                                <input
                                    type="hidden"
                                    name="price"
                                    value="<?= $product["price"] ?>"
                                >

                                <button type="submit">
                                    Add to Cart
                                </button>

                            </form>

                        </div>

                    <?php endforeach; ?>

                </div>

            </section>


            <!-- CART AND HISTORY -->

            <section class="bottom-section">


                <!-- SHOPPING CART -->

                <div class="info-panel">

                    <div class="panel-heading">

                        <h2>
                            🛒 Shopping Cart
                        </h2>

                        <?php if (!empty($_SESSION["cart"])): ?>

                            <form
                                action="process.php"
                                method="POST"
                            >

                                <input
                                    type="hidden"
                                    name="action"
                                    value="clear"
                                >

                                <button
                                    type="submit"
                                    class="clear-button"
                                >
                                    Clear Cart
                                </button>

                            </form>

                        <?php endif; ?>

                    </div>


                    <?php if (empty($_SESSION["cart"])): ?>

                        <div class="empty-box">

                            <div>
                                🛒
                            </div>

                            <p>
                                Your shopping cart is empty.
                            </p>

                        </div>

                    <?php else: ?>

                        <?php foreach ($_SESSION["cart"] as $index => $item): ?>

                            <div class="cart-item">

                                <div>

                                    <strong>
                                        <?= htmlspecialchars($item["name"]) ?>
                                    </strong>

                                    <span>
                                        ₹<?= number_format($item["price"]) ?>
                                    </span>

                                </div>


                                <form
                                    action="process.php"
                                    method="POST"
                                >

                                    <input
                                        type="hidden"
                                        name="action"
                                        value="remove"
                                    >

                                    <input
                                        type="hidden"
                                        name="index"
                                        value="<?= $index ?>"
                                    >

                                    <button
                                        type="submit"
                                        class="remove-button"
                                    >
                                        Remove
                                    </button>

                                </form>

                            </div>

                        <?php endforeach; ?>


                        <div class="total-row">

                            <span>
                                Total Amount
                            </span>

                            <strong>
                                ₹<?= number_format($cartTotal) ?>
                            </strong>

                        </div>

                    <?php endif; ?>

                </div>


                <!-- BROWSING HISTORY -->

                <div class="info-panel">

                    <div class="panel-heading">

                        <h2>
                            🕘 Browsing History
                        </h2>

                    </div>


                    <?php if (empty($_SESSION["history"])): ?>

                        <div class="empty-box">

                            <div>
                                🔎
                            </div>

                            <p>
                                No products viewed yet.
                            </p>

                        </div>

                    <?php else: ?>

                        <?php foreach (array_reverse($_SESSION["history"]) as $historyItem): ?>

                            <div class="history-item">

                                <span class="history-icon">
                                    👁️
                                </span>

                                <span>
                                    <?= htmlspecialchars($historyItem) ?>
                                </span>

                            </div>

                        <?php endforeach; ?>

                    <?php endif; ?>

                </div>

            </section>


            <!-- USER SESSION INFORMATION -->

            <section class="session-box">

                <h2>
                    Account Information
                </h2>

                <div class="session-details">

                    <div>
                        <span>Username</span>

                        <strong>
                            <?= htmlspecialchars($loggedInUser) ?>
                        </strong>
                    </div>

                    <div>
                        <span>Login Status</span>

                        <strong>
                            Active
                        </strong>
                    </div>

                    <div>
                        <span>Shopping Session</span>

                        <strong>
                            Active
                        </strong>
                    </div>

                </div>

            </section>

        <?php endif; ?>

    </main>


    <footer>

        <p>
            Online Shopping User Management System
        </p>

    </footer>

</div>

</body>

</html>