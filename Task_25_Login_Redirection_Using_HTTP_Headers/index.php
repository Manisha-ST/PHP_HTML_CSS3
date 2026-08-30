<?php

session_start();


// Check if user is already logged in

if (isset($_SESSION["logged_in"]) &&
    $_SESSION["logged_in"] === true) {

    header("Location: process.php?page=dashboard");

    exit();

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

    <title>
        Secure Login
    </title>

    <link rel="stylesheet" href="style.css">

</head>

<body>

<div class="container">

    <header>

        <div class="icon">
            🔑
        </div>

        <h1>
            Secure Login Portal
        </h1>

        <p>
            Login to access your dashboard
        </p>

    </header>


    <main>

        <?php

        $message = $_GET["message"] ?? "";

        $type = $_GET["type"] ?? "";

        ?>


        <?php if ($message != ""): ?>

            <div class="message <?= htmlspecialchars($type) ?>">

                <?= htmlspecialchars($message) ?>

            </div>

        <?php endif; ?>


        <section class="login-card">

            <div class="login-icon">
                👤
            </div>

            <h2>
                User Login
            </h2>

            <p class="description">
                Enter your credentials to continue.
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

                        Username

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

                    Login & Continue →

                </button>

            </form>


            <div class="demo">

                <strong>
                    Demo Login
                </strong>

                <p>
                    Username: <b>admin</b>
                </p>

                <p>
                    Password: <b>12345</b>
                </p>

            </div>

        </section>


        <section class="info">

            <h2>
                🔒 Secure Authentication
            </h2>

            <p>
                After successful authentication, PHP uses
                an HTTP header to redirect the user to the
                protected dashboard page.
            </p>

        </section>

    </main>


    <footer>

        Login Redirection Using HTTP Headers

    </footer>

</div>

</body>

</html>