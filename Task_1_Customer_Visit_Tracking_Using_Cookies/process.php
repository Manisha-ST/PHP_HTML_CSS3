<?php

// Check whether the form was submitted
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: index.php");
    exit();
}

// Get form values
$customerName = trim($_POST["customer_name"] ?? "");
$preference = trim($_POST["preference"] ?? "");

// Validate required fields
if ($customerName === "" || $preference === "") {
    die("Please fill in all required fields.");
}

// Store customer name in a cookie
setcookie(
    "customer_name",
    $customerName,
    time() + (86400 * 30),
    "/"
);

// Store customer preference in a cookie
setcookie(
    "customer_preference",
    $preference,
    time() + (86400 * 30),
    "/"
);

// Get previous visit count
$previousVisits = isset($_COOKIE["visit_count"])
    ? (int) $_COOKIE["visit_count"]
    : 0;

// Increase visit count
$currentVisits = $previousVisits + 1;

// Store updated visit count
setcookie(
    "visit_count",
    $currentVisits,
    time() + (86400 * 30),
    "/"
);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Customer Visit Result</title>

    <link rel="stylesheet" href="style.css">
</head>

<body>

    <div class="container">

        <header>
            <h1>Welcome Back!</h1>
            <p>Customer Visit Information</p>
        </header>

        <div class="result-card">

            <?php if ($previousVisits > 0): ?>

                <div class="welcome">
                    <h2>
                        Welcome back,
                        <?= htmlspecialchars($customerName) ?>!
                    </h2>

                    <p>
                        We remember your previous visit.
                    </p>
                </div>

            <?php else: ?>

                <div class="welcome">
                    <h2>
                        Welcome,
                        <?= htmlspecialchars($customerName) ?>!
                    </h2>

                    <p>
                        Thank you for visiting our website for the first time.
                    </p>
                </div>

            <?php endif; ?>

            <div class="details">

                <div class="detail-box">
                    <h3>Customer Name</h3>

                    <p>
                        <?= htmlspecialchars($customerName) ?>
                    </p>
                </div>

                <div class="detail-box">
                    <h3>Preference</h3>

                    <p>
                        <?= htmlspecialchars($preference) ?>
                    </p>
                </div>

                <div class="detail-box">
                    <h3>Total Visits</h3>

                    <p>
                        <?= $currentVisits ?>
                    </p>
                </div>

            </div>

            <a href="index.php" class="back-button">
                Visit Again
            </a>

        </div>

    </div>

</body>

</html>