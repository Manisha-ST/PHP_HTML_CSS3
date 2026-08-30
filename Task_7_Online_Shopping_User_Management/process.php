<?php

session_start();

/*
 * Check whether the request is POST.
 */

if ($_SERVER["REQUEST_METHOD"] !== "POST") {

    header("Location: index.php");

    exit();

}


/*
 * Get requested action.
 */

$action = $_POST["action"] ?? "";


/*
 * LOGIN
 */

if ($action === "login") {

    $username = trim($_POST["username"] ?? "");


    if ($username === "") {

        die("
            <h2>Login Error</h2>
            <p>Username is required.</p>
            <a href='index.php'>Go Back</a>
        ");

    }


    /*
     * Store username in session.
     */

    $_SESSION["username"] = $username;


    /*
     * Create shopping cart.
     */

    $_SESSION["cart"] = [];


    /*
     * Create browsing history.
     */

    $_SESSION["history"] = [];


    /*
     * Store username in cookie.
     * Cookie remains for 30 days.
     */

    setcookie(
        "shopping_user",
        $username,
        time() + (86400 * 30),
        "/"
    );


    /*
     * Store login time in cookie.
     */

    $loginTime = date("d-m-Y h:i:s A");

    setcookie(
        "last_login",
        $loginTime,
        time() + (86400 * 30),
        "/"
    );


    header("Location: index.php");

    exit();

}


/*
 * ADD PRODUCT TO CART
 */

if ($action === "add") {


    /*
     * Make sure user is logged in.
     */

    if (!isset($_SESSION["username"])) {

        header("Location: index.php");

        exit();

    }


    $product = trim($_POST["product"] ?? "");

    $price = (float) ($_POST["price"] ?? 0);


    /*
     * Validate product.
     */

    if ($product === "" || $price <= 0) {

        die("
            <h2>Product Error</h2>
            <p>Invalid product information.</p>
            <a href='index.php'>Go Back</a>
        ");

    }


    /*
     * Add product to session cart.
     */

    $_SESSION["cart"][] = [

        "name" => $product,

        "price" => $price

    ];


    /*
     * Add product to browsing history.
     */

    $_SESSION["history"][] = $product;


    header("Location: index.php");

    exit();

}


/*
 * REMOVE PRODUCT FROM CART
 */

if ($action === "remove") {


    if (!isset($_SESSION["username"])) {

        header("Location: index.php");

        exit();

    }


    $index = $_POST["index"] ?? "";


    if (
        $index !== "" &&
        isset($_SESSION["cart"][$index])
    ) {

        /*
         * Remove selected item.
         */

        unset($_SESSION["cart"][$index]);


        /*
         * Rearrange array indexes.
         */

        $_SESSION["cart"] = array_values(
            $_SESSION["cart"]
        );

    }


    header("Location: index.php");

    exit();

}


/*
 * CLEAR CART
 */

if ($action === "clear") {


    if (!isset($_SESSION["username"])) {

        header("Location: index.php");

        exit();

    }


    $_SESSION["cart"] = [];


    header("Location: index.php");

    exit();

}


/*
 * LOGOUT
 */

if ($action === "logout") {


    /*
     * Destroy the session.
     */

    session_unset();

    session_destroy();


    /*
     * Delete username cookie.
     */

    setcookie(
        "shopping_user",
        "",
        time() - 3600,
        "/"
    );


    /*
     * Delete login-time cookie.
     */

    setcookie(
        "last_login",
        "",
        time() - 3600,
        "/"
    );


    header("Location: index.php");

    exit();

}


/*
 * Invalid action.
 */

die("
    <h2>Invalid Request</h2>
    <p>The requested operation could not be completed.</p>
    <a href='index.php'>Go Back</a>
");

?>