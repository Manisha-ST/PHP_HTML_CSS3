<?php

session_start();


/*
 * If user is already logged in using session,
 * redirect to dashboard.
 */

if (isset($_SESSION["username"])) {

    header("Location: dashboard.php");

    exit();

}


/*
 * Check Remember Me cookie.
 */

$rememberedUsername = "";

if (isset($_COOKIE["remember_username"])) {

    $rememberedUsername =
        $_COOKIE["remember_username"];

}


/*
 * Get error message.
 */

$errorMessage = $_SESSION["error"] ?? "";

unset($_SESSION["error"]);

?>

<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Secure Login Management</title>

    <link rel="stylesheet" href="style.css">

</head>

<body>

<div class="page-container">

    <div class="login-box">

        <div class="login-header">

            <div class="shield">
                🔐
            </div>

            <h1>
                Secure Login
            </h1>

            <p>
                Session and Cookie Based Authentication
            </p>

        </div>


        <?php if ($errorMessage !== ""): ?>

            <div class="message error">

                <?= htmlspecialchars($errorMessage) ?>

            </div>

        <?php endif; ?>


        <form
            action="process.php"
            method="POST"
        >

            <div class="form-group">

                <label for="username">
                    Username
                </label>

                <input
                    type="text"
                    id="username"
                    name="username"
                    placeholder="Enter username"
                    value="<?= htmlspecialchars($rememberedUsername) ?>"
                    required
                >

            </div>


            <div class="form-group">

                <label for="password">
                    Password
                </label>

                <input
                    type="password"
                    id="password"
                    name="password"
                    placeholder="Enter password"
                    required
                >

            </div>


            <label class="remember">

                <input
                    type="checkbox"
                    name="remember"
                    value="yes"
                    <?= $rememberedUsername !== "" ? "checked" : "" ?>
                >

                <span>
                    Remember my username using Cookie
                </span>

            </label>


            <button type="submit">

                Login Securely

            </button>

        </form>


        <div class="login-info">

            <h3>
                Login Details
            </h3>

            <p>
                Username:
                <strong>student</strong>
            </p>

            <p>
                Password:
                <strong>12345</strong>
            </p>

        </div>

    </div>

</div>

</body>

</html>