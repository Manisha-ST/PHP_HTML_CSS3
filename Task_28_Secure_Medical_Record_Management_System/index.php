<?php

session_start();


// Check if user is already logged in

if (
    isset($_SESSION["medical_logged_in"]) &&
    $_SESSION["medical_logged_in"] === true
) {

    header("Location: process.php?page=records");

    exit();

}


$message = $_GET["message"] ?? "";

$type = $_GET["type"] ?? "";

?>

<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Secure Medical Records
    </title>

    <link rel="stylesheet" href="style.css">

</head>

<body>

<div class="container">

    <header>

        <div class="icon">
            🏥
        </div>

        <h1>
            Secure Medical Records
        </h1>

        <p>
            Protected Medical Record Management System
        </p>

    </header>


    <main>

        <?php if ($message != ""): ?>

            <div class="message <?= htmlspecialchars($type) ?>">

                <?= htmlspecialchars($message) ?>

            </div>

        <?php endif; ?>


        <section class="login-card">

            <div class="lock-icon">
                🔐
            </div>

            <h2>
                Authorized Login
            </h2>

            <p class="description">

                Login to securely access patient medical records.

            </p>


            <form
                action="process.php"
                method="POST"
            >

                <input
                    type="hidden"
                    name="action"
                    value="login"
                >


                <div class="form-group">

                    <label for="username">

                        Medical Staff ID

                    </label>

                    <input
                        type="text"
                        id="username"
                        name="username"
                        placeholder="Enter staff ID"
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


                <button type="submit">

                    🔓 Secure Login

                </button>

            </form>


            <div class="demo">

                <strong>
                    Demo Login
                </strong>

                <p>
                    Staff ID:
                    <b>doctor</b>
                </p>

                <p>
                    Password:
                    <b>medical123</b>
                </p>

            </div>

        </section>


        <section class="security">

            <h2>
                🛡️ Security Measures
            </h2>

            <div class="security-grid">

                <div>

                    <span>
                        🔐
                    </span>

                    <strong>
                        Secure Sessions
                    </strong>

                    <p>
                        Medical access is controlled using PHP sessions.
                    </p>

                </div>


                <div>

                    <span>
                        📁
                    </span>

                    <strong>
                        Secure File Handling
                    </strong>

                    <p>
                        Medical records are stored and accessed through PHP.
                    </p>

                </div>


                <div>

                    <span>
                        🚫
                    </span>

                    <strong>
                        Access Protection
                    </strong>

                    <p>
                        Unauthorized users cannot access protected records.
                    </p>

                </div>

            </div>

        </section>

    </main>


    <footer>

        Secure Medical Record Management System

    </footer>

</div>

</body>

</html>