<?php

session_start();

/*
 * Check whether request is POST.
 */

if ($_SERVER["REQUEST_METHOD"] !== "POST") {

    header("Location: index.php");

    exit();

}


/*
 * Get action.
 */

$action = $_POST["action"] ?? "";


/*
 * Activity file.
 */

$activityFile = "student_activities.txt";


/*
 * Add activity.
 */

if ($action === "add") {


    /*
     * Get form values.
     */

    $studentName = trim(
        $_POST["student_name"] ?? ""
    );

    $registerNumber = trim(
        $_POST["register_number"] ?? ""
    );

    $activity = trim(
        $_POST["activity"] ?? ""
    );

    $status = trim(
        $_POST["status"] ?? ""
    );

    $description = trim(
        $_POST["description"] ?? ""
    );


    /*
     * Validate required fields.
     */

    if (
        $studentName === "" ||
        $registerNumber === "" ||
        $activity === "" ||
        $status === "" ||
        $description === ""
    ) {

        $_SESSION["error"] =
            "Please fill in all required fields.";

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
     * Get current date and time.
     */

    $currentDateTime = date(
        "d-m-Y h:i:s A"
    );


    /*
     * Create activity record.
     */

    $activityRecord = [

        "student_name" => $studentName,

        "register_number" => $registerNumber,

        "activity" => $activity,

        "status" => $status,

        "description" => $description,

        "date" => $currentDateTime

    ];


    /*
     * Store activity in session.
     */

    $_SESSION["activities"][] =
        $activityRecord;


    /*
     * Prepare record for file.
     */

    $fileRecord =
        "Student: " . $studentName .
        " | Register No: " . $registerNumber .
        " | Activity: " . $activity .
        " | Status: " . $status .
        " | Description: " . $description .
        " | Date: " . $currentDateTime .
        PHP_EOL;


    /*
     * Append activity to file.
     */

    $fileResult = file_put_contents(
        $activityFile,
        $fileRecord,
        FILE_APPEND | LOCK_EX
    );


    /*
     * Check whether file writing was successful.
     */

    if ($fileResult === false) {

        $_SESSION["error"] =
            "Activity could not be saved to the file.";

    } else {

        $_SESSION["success"] =
            "Student activity added successfully.";

    }


    header("Location: index.php");

    exit();

}


/*
 * Invalid request.
 */

$_SESSION["error"] =
    "Invalid request.";

header("Location: index.php");

exit();

?>