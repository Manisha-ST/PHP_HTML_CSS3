<?php

session_start();


// Check whether user is already authenticated

if (
    isset($_SESSION["exam_authenticated"]) &&
    $_SESSION["exam_authenticated"] === true
) {

    header("Location: process.php?page=exam");

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
        Secure Examination Access
    </title>

    <link rel="stylesheet" href="style.css">

</head>

<body>

<div class="container">

    <header>

        <div class="icon">
            🎓
        </div>

        <h1>
            Secure Examination Portal
        </h1>

        <p>
            Authorized access for online examination
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
                Examination Login
            </h2>

            <p class="description">
                Enter your credentials to access the examination.
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

                        Student Username

                    </label>

                    <input
                        type="text"
                        id="username"
                        name="username"
                        placeholder="Enter username"
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

                    🔓 Login to Examination

                </button>

            </form>


            <div class="demo">

                <strong>
                    Demo Credentials
                </strong>

                <p>
                    Username:
                    <b>student</b>
                </p>

                <p>
                    Password:
                    <b>exam123</b>
                </p>

            </div>

        </section>


        <section class="security">

            <h2>
                🛡️ Security Features
            </h2>

            <div class="security-grid">

                <div>

                    <span>
                        🔐
                    </span>

                    <strong>
                        Session Authentication
                    </strong>

                    <p>
                        Maintains secure login status.
                    </p>

                </div>


                <div>

                    <span>
                        🍪
                    </span>

                    <strong>
                        Cookie Management
                    </strong>

                    <p>
                        Stores authorized user information.
                    </p>

                </div>


                <div>

                    <span>
                        🚫
                    </span>

                    <strong>
                        Access Control
                    </strong>

                    <p>
                        Prevents unauthorized examination access.
                    </p>

                </div>

            </div>

        </section>

    </main>


    <footer>

        Secure Examination Access Control System

    </footer>

</div>

</body>

</html>