<?php

session_start();


// --------------------------------------------------
// LOGIN PROCESS
// --------------------------------------------------

if (
    $_SERVER["REQUEST_METHOD"] === "POST" &&
    ($_POST["action"] ?? "") === "login"
) {


    $username = trim(
        $_POST["username"] ?? ""
    );


    $password = $_POST["password"] ?? "";


    // Validate empty fields

    if (
        $username === "" ||
        $password === ""
    ) {

        header(
            "Location: index.php?message=Please enter username and password.&type=error"
        );

        exit();

    }


    // Demo login credentials

    $correctUsername = "admin";

    $correctPassword = "12345";


    // Authenticate user

    if (
        $username === $correctUsername &&
        $password === $correctPassword
    ) {


        // Regenerate session ID

        session_regenerate_id(true);


        // Store authentication information

        $_SESSION["logged_in"] = true;

        $_SESSION["username"] = $username;

        $_SESSION["login_time"] =
            date("d-m-Y h:i:s A");


        // HTTP header redirection

        header(
            "Location: process.php?page=dashboard"
        );

        exit();

    }


    // Invalid login

    header(
        "Location: index.php?message=Invalid username or password.&type=error"
    );

    exit();

}



// --------------------------------------------------
// DASHBOARD
// --------------------------------------------------

if (
    isset($_GET["page"]) &&
    $_GET["page"] === "dashboard"
) {


    // Check authentication

    if (
        !isset($_SESSION["logged_in"]) ||
        $_SESSION["logged_in"] !== true
    ) {

        header(
            "Location: index.php?message=Please login first to access the dashboard.&type=error"
        );

        exit();

    }


    $username =
        $_SESSION["username"];


    $loginTime =
        $_SESSION["login_time"];


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
            User Dashboard
        </title>

        <link rel="stylesheet" href="style.css">

    </head>

    <body>

    <div class="container">

        <header class="dashboard-header">

            <div class="icon">
                🎉
            </div>

            <h1>
                Welcome to Dashboard
            </h1>

            <p>
                Authentication successful
            </p>

        </header>


        <main>

            <section class="welcome-card">

                <div class="success-icon">
                    ✓
                </div>

                <h2>
                    Login Successful!
                </h2>

                <p>
                    Welcome,
                    <strong>
                        <?= htmlspecialchars($username) ?>
                    </strong>
                </p>

                <p class="login-time">

                    Login Time:
                    <?= htmlspecialchars($loginTime) ?>

                </p>

            </section>


            <section class="dashboard-grid">

                <div class="dashboard-item">

                    <div class="item-icon">
                        👤
                    </div>

                    <h3>
                        User Account
                    </h3>

                    <p>
                        Username:
                        <?= htmlspecialchars($username) ?>
                    </p>

                </div>


                <div class="dashboard-item">

                    <div class="item-icon">
                        🔐
                    </div>

                    <h3>
                        Authentication
                    </h3>

                    <p>
                        Status:
                        <strong class="active">
                            Authenticated
                        </strong>
                    </p>

                </div>


                <div class="dashboard-item">

                    <div class="item-icon">
                        🕐
                    </div>

                    <h3>
                        Login Session
                    </h3>

                    <p>
                        Session is active
                    </p>

                </div>

            </section>


            <section class="redirect-info">

                <h2>
                    HTTP Header Redirection
                </h2>

                <p>
                    This dashboard was reached after
                    successful authentication using the
                    PHP
                    <strong>header("Location: ...")</strong>
                    function.
                </p>

            </section>


            <a
                href="process.php?action=logout"
                class="logout"
            >

                Logout

            </a>

        </main>


        <footer>

            Secure Login and HTTP Header Redirection

        </footer>

    </div>

    </body>

    </html>

    <?php

    exit();

}



// --------------------------------------------------
// LOGOUT
// --------------------------------------------------

if (
    isset($_GET["action"]) &&
    $_GET["action"] === "logout"
) {


    // Destroy session

    $_SESSION = [];


    session_destroy();


    // Redirect to login page

    header(
        "Location: index.php?message=You have been logged out successfully.&type=success"
    );

    exit();

}



// --------------------------------------------------
// INVALID REQUEST
// --------------------------------------------------

header(
    "Location: index.php?message=Invalid request.&type=error"
);

exit();

?>