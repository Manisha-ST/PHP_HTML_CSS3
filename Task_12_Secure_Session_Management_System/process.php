<?php

session_start();


/*
 * Allow only POST requests.
 */

if ($_SERVER["REQUEST_METHOD"] !== "POST") {

    header("Location: index.php");

    exit();

}


/*
 * Get form values.
 */

$username = trim(
    $_POST["username"] ?? ""
);

$password = trim(
    $_POST["password"] ?? ""
);

$remember =
    $_POST["remember"] ?? "";


/*
 * Validate empty fields.
 */

if (
    $username === "" ||
    $password === ""
) {

    $_SESSION["error"] =
        "Please enter both username and password.";

    header("Location: index.php");

    exit();

}


/*
 * Demo login credentials.
 */

$validUsername = "student";

$validPassword = "12345";


/*
 * Verify login details.
 */

if (
    $username === $validUsername &&
    $password === $validPassword
) {


    /*
     * Regenerate session ID for better security.
     */

    session_regenerate_id(true);


    /*
     * Store user details in session.
     */

    $_SESSION["username"] =
        $username;

    $_SESSION["login_time"] =
        date("d-m-Y h:i:s A");


    /*
     * Cookie-based Remember Me feature.
     */

    if ($remember === "yes") {

        setcookie(
            "remember_username",
            $username,
            time() + (7 * 24 * 60 * 60),
            "/",
            "",
            false,
            true
        );

    } else {


        /*
         * Remove existing cookie.
         */

        setcookie(
            "remember_username",
            "",
            time() - 3600,
            "/"
        );

    }


    header("Location: dashboard.php");

    exit();

}


/*
 * Invalid login.
 */

$_SESSION["error"] =
    "Invalid username or password.";

header("Location: index.php");

exit();

?>