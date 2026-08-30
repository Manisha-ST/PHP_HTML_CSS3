<?php

session_start();

$studentFile = "student_records.txt";


/*
 * Make sure the request is POST.
 */

if ($_SERVER["REQUEST_METHOD"] !== "POST") {

    header("Location: index.php");

    exit();

}


$action = $_POST["action"] ?? "";


/*
 * Add student record.
 */

if ($action === "add") {


    $studentName = trim(
        $_POST["student_name"] ?? ""
    );

    $registerNumber = trim(
        $_POST["register_number"] ?? ""
    );

    $course = trim(
        $_POST["course"] ?? ""
    );

    $year = trim(
        $_POST["year"] ?? ""
    );

    $email = trim(
        $_POST["email"] ?? ""
    );

    $phone = trim(
        $_POST["phone"] ?? ""
    );


    /*
     * Validate empty fields.
     */

    if (
        $studentName === "" ||
        $registerNumber === "" ||
        $course === "" ||
        $year === "" ||
        $email === "" ||
        $phone === ""
    ) {

        $_SESSION["error"] =
            "Please fill in all the required fields.";

        header("Location: index.php");

        exit();

    }


    /*
     * Validate student name.
     */

    if (!preg_match(
        "/^[a-zA-Z ]+$/",
        $studentName
    )) {

        $_SESSION["error"] =
            "Student name should contain only letters.";

        header("Location: index.php");

        exit();

    }


    /*
     * Validate register number.
     */

    if (!preg_match(
        "/^[A-Za-z0-9]+$/",
        $registerNumber
    )) {

        $_SESSION["error"] =
            "Invalid register number.";

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

        $_SESSION["error"] =
            "Please enter a valid email address.";

        header("Location: index.php");

        exit();

    }


    /*
     * Validate phone number.
     */

    if (!preg_match(
        "/^[0-9]{10}$/",
        $phone
    )) {

        $_SESSION["error"] =
            "Phone number must contain exactly 10 digits.";

        header("Location: index.php");

        exit();

    }


    /*
     * Create the record.
     */

    $record =
        "Name: " . $studentName .
        " | Register No: " . $registerNumber .
        " | Course: " . $course .
        " | Year: " . $year .
        " | Email: " . $email .
        " | Phone: " . $phone;


    /*
     * Append the new record to the file.
     */

    $result = file_put_contents(
        $studentFile,
        $record . PHP_EOL,
        FILE_APPEND | LOCK_EX
    );


    /*
     * Check whether the record was stored.
     */

    if ($result === false) {

        $_SESSION["error"] =
            "Unable to save the student record.";

    } else {

        $_SESSION["success"] =
            "Student record added successfully.";

    }


    header("Location: index.php");

    exit();

}


/*
 * Invalid action.
 */

$_SESSION["error"] =
    "Invalid request.";

header("Location: index.php");

exit();

?>