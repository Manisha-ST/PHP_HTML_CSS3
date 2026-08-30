<?php

session_start();


$eventsFile = "events.txt";


/*
 * Allow only POST requests.
 */

if ($_SERVER["REQUEST_METHOD"] !== "POST") {

    header("Location: index.php");

    exit();

}


$action = $_POST["action"] ?? "";


if ($action === "register") {


    /*
     * Get form values.
     */

    $name = trim(
        $_POST["name"] ?? ""
    );

    $email = trim(
        $_POST["email"] ?? ""
    );

    $event = trim(
        $_POST["event"] ?? ""
    );

    $eventDate = trim(
        $_POST["event_date"] ?? ""
    );

    $eventTime = trim(
        $_POST["event_time"] ?? ""
    );

    $participants = trim(
        $_POST["participants"] ?? ""
    );


    /*
     * Validate required fields.
     */

    if (
        $name === "" ||
        $email === "" ||
        $event === "" ||
        $eventDate === "" ||
        $eventTime === "" ||
        $participants === ""
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
            "Please enter a valid participant name.";

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
     * Validate number of participants.
     */

    if (
        !is_numeric($participants) ||
        $participants < 1 ||
        $participants > 10
    ) {

        $_SESSION["message"] =
            "Participants must be between 1 and 10.";

        $_SESSION["message_type"] =
            "error";

        header("Location: index.php");

        exit();

    }


    /*
     * Validate event date.
     */

    $today = date("Y-m-d");

    if ($eventDate < $today) {

        $_SESSION["message"] =
            "Event date cannot be in the past.";

        $_SESSION["message_type"] =
            "error";

        header("Location: index.php");

        exit();

    }


    /*
     * Format date for display.
     */

    $formattedDate = date(
        "d M Y",
        strtotime($eventDate)
    );


    /*
     * Format time for display.
     */

    $formattedTime = date(
        "h:i A",
        strtotime($eventTime)
    );


    /*
     * Create event record.
     */

    $record =
        $name . "|" .
        $event . "|" .
        $email . "|" .
        $formattedDate . "|" .
        $formattedTime . "|" .
        $participants;


    /*
     * Store event information in file.
     */

    $result = file_put_contents(
        $eventsFile,
        $record . PHP_EOL,
        FILE_APPEND | LOCK_EX
    );


    if ($result === false) {

        $_SESSION["message"] =
            "Unable to save event registration.";

        $_SESSION["message_type"] =
            "error";

    } else {

        $_SESSION["message"] =
            "Event registration completed successfully!";

        $_SESSION["message_type"] =
            "success";

    }


    header("Location: index.php");

    exit();

}


/*
 * Invalid request.
 */

$_SESSION["message"] =
    "Invalid request.";

$_SESSION["message_type"] =
    "error";

header("Location: index.php");

exit();

?>