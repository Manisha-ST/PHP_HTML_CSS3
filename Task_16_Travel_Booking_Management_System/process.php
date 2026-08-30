<?php

session_start();

$bookingsFile = "bookings.txt";


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

$name = trim(
    $_POST["name"] ?? ""
);

$email = trim(
    $_POST["email"] ?? ""
);

$destination = trim(
    $_POST["destination"] ?? ""
);

$travelDate = trim(
    $_POST["travel_date"] ?? ""
);

$returnDate = trim(
    $_POST["return_date"] ?? ""
);

$travelers = trim(
    $_POST["travelers"] ?? ""
);


/*
 * Validate empty fields.
 */

if (
    $name === "" ||
    $email === "" ||
    $destination === "" ||
    $travelDate === "" ||
    $returnDate === "" ||
    $travelers === ""
) {

    $_SESSION["message"] =
        "Please fill in all the required fields.";

    $_SESSION["message_type"] =
        "error";

    header("Location: index.php");

    exit();

}


/*
 * Validate name.
 */

if (!preg_match(
    "/^[a-zA-Z ]+$/",
    $name
)) {

    $_SESSION["message"] =
        "Please enter a valid customer name.";

    $_SESSION["message_type"] =
        "error";

    header("Location: index.php");

    exit();

}


/*
 * Validate email.
 */

if (!filter_var(
    $email,
    FILTER_VALIDATE_EMAIL
)) {

    $_SESSION["message"] =
        "Please enter a valid email address.";

    $_SESSION["message_type"] =
        "error";

    header("Location: index.php");

    exit();

}


/*
 * Validate number of travelers.
 */

if (
    !is_numeric($travelers) ||
    $travelers < 1 ||
    $travelers > 10
) {

    $_SESSION["message"] =
        "Number of travelers must be between 1 and 10.";

    $_SESSION["message_type"] =
        "error";

    header("Location: index.php");

    exit();

}


/*
 * Validate travel dates.
 */

$today = date("Y-m-d");


if ($travelDate < $today) {

    $_SESSION["message"] =
        "Travel date cannot be in the past.";

    $_SESSION["message_type"] =
        "error";

    header("Location: index.php");

    exit();

}


if ($returnDate < $travelDate) {

    $_SESSION["message"] =
        "Return date must be after the travel date.";

    $_SESSION["message_type"] =
        "error";

    header("Location: index.php");

    exit();

}


/*
 * Format dates.
 */

$formattedTravelDate = date(
    "d M Y",
    strtotime($travelDate)
);

$formattedReturnDate = date(
    "d M Y",
    strtotime($returnDate)
);


/*
 * Store customer information
 * in the session.
 */

$_SESSION["customer_name"] = $name;

$_SESSION["customer_email"] = $email;

$_SESSION["destination"] = $destination;


/*
 * Create booking ID.
 */

$bookingId =
    "TRV" . date("YmdHis");


$_SESSION["booking_id"] =
    $bookingId;


/*
 * Create booking record.
 */

$record =
    $name . "|" .
    $email . "|" .
    $destination . "|" .
    $formattedTravelDate . "|" .
    $formattedReturnDate . "|" .
    $travelers . "|" .
    $bookingId;


/*
 * Save booking using file handling.
 */

$result = file_put_contents(
    $bookingsFile,
    $record . PHP_EOL,
    FILE_APPEND | LOCK_EX
);


if ($result === false) {

    $_SESSION["message"] =
        "Unable to save the booking.";

    $_SESSION["message_type"] =
        "error";

} else {

    $_SESSION["message"] =
        "Travel booking confirmed successfully! Booking ID: "
        . $bookingId;

    $_SESSION["message_type"] =
        "success";

}


header("Location: index.php");

exit();

?>