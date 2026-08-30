<?php

session_start();


/*
 * Protect the page using session authentication.
 */

if (!isset($_SESSION["username"])) {

    header("Location: index.php");

    exit();

}


$username =
    $_SESSION["username"];

$loginTime =
    $_SESSION["login_time"];


/*
 * Check cookie status.
 */

$cookieStatus =
    isset($_COOKIE["remember_username"]);

?>

<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>User Dashboard</title>

    <link rel="stylesheet" href="style.css">

</head>

<body>

<div class="page-container">

    <div class="dashboard-box">


        <div class="dashboard-top">

            <div>

                <span class="small-title">
                    AUTHENTICATED USER
                </span>

                <h1>
                    Welcome,
                    <?= htmlspecialchars($username) ?>!
                </h1>

                <p>
                    You have successfully logged in.
                </p>

            </div>

            <div class="user-icon">
                👤
            </div>

        </div>


        <section class="status-grid">


            <div class="status-card session-card">

                <div class="status-icon">
                    🔑
                </div>

                <h2>
                    Session Authentication
                </h2>

                <p>
                    Your login status is currently maintained
                    using a PHP session.
                </p>

                <span class="active">
                    Active
                </span>

            </div>


            <div class="status-card cookie-card">

                <div class="status-icon">
                    🍪
                </div>

                <h2>
                    Cookie Authentication
                </h2>

                <?php if ($cookieStatus): ?>

                    <p>
                        Your username is stored in a cookie
                        for the Remember Me feature.
                    </p>

                    <span class="active">
                        Remembered
                    </span>

                <?php else: ?>

                    <p>
                        No Remember Me cookie is currently
                        stored in your browser.
                    </p>

                    <span class="inactive">
                        Not Active
                    </span>

                <?php endif; ?>

            </div>

        </section>


        <section class="login-details">

            <h2>
                Login Information
            </h2>

            <div class="detail-row">

                <span>
                    Username
                </span>

                <strong>
                    <?= htmlspecialchars($username) ?>
                </strong>

            </div>


            <div class="detail-row">

                <span>
                    Login Time
                </span>

                <strong>
                    <?= htmlspecialchars($loginTime) ?>
                </strong>

            </div>


            <div class="detail-row">

                <span>
                    Authentication
                </span>

                <strong>
                    Session Protected
                </strong>

            </div>

        </section>


        <section class="security-note">

            <div>
                🛡️
            </div>

            <div>

                <h3>
                    Secure Access
                </h3>

                <p>
                    This dashboard cannot be accessed without
                    a valid session login.
                </p>

            </div>

        </section>


        <a
            href="logout.php"
            class="logout-button"
        >

            Logout

        </a>

    </div>

</div>

</body>

</html>