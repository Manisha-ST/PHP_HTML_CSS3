<?php

// Check whether the form was submitted
if ($_SERVER["REQUEST_METHOD"] !== "POST") {

    header("Location: index.php");
    exit();

}

// Get username and password
$username = trim($_POST["username"] ?? "");
$password = trim($_POST["password"] ?? "");

// Validate input
if ($username === "" || $password === "") {

    $errorMessage = "Please enter both username and password.";

} else {

    /*
     * Check whether a previous login cookie exists.
     * This cookie contains the previous login time.
     */
    $previousLogin = $_COOKIE["last_login"] ?? "";

    /*
     * Create the current login time.
     */
    $currentLogin = date("d-m-Y h:i:s A");

    /*
     * Store username in a cookie.
     */
    setcookie(
        "login_username",
        $username,
        time() + (86400 * 30),
        "/"
    );

    /*
     * Store current login time in a cookie.
     * It will be available during the next login.
     */
    setcookie(
        "last_login",
        $currentLogin,
        time() + (86400 * 30),
        "/"
    );

}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Login Result</title>

    <link rel="stylesheet" href="style.css">

</head>

<body>

    <div class="container">

        <header>
            <h1>Login Information</h1>
            <p>Cookie-based login tracking</p>
        </header>

        <?php if (isset($errorMessage)): ?>

            <main class="result-card error-card">

                <div class="status-icon">
                    ❌
                </div>

                <h2>Login Failed</h2>

                <p class="error-message">
                    <?= htmlspecialchars($errorMessage) ?>
                </p>

                <a href="index.php" class="button">
                    Try Again
                </a>

            </main>

        <?php else: ?>

            <main class="result-card">

                <div class="status-icon success-icon">
                    ✓
                </div>

                <h2>Login Successful</h2>

                <p class="welcome">
                    Welcome,
                    <strong>
                        <?= htmlspecialchars($username) ?>
                    </strong>
                </p>

                <?php if ($previousLogin !== ""): ?>

                    <div class="login-box">

                        <h3>Previous Login</h3>

                        <p>
                            <?= htmlspecialchars($previousLogin) ?>
                        </p>

                    </div>

                <?php else: ?>

                    <div class="login-box first-login">

                        <h3>First Login</h3>

                        <p>
                            This is your first recorded login.
                        </p>

                    </div>

                <?php endif; ?>

                <div class="current-box">

                    <h3>Current Login</h3>

                    <p>
                        <?= htmlspecialchars($currentLogin) ?>
                    </p>

                </div>

                <a href="index.php" class="button">
                    Login Again
                </a>

            </main>

        <?php endif; ?>

    </div>

</body>

</html>