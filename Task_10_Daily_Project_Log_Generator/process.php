<?php

session_start();


/*
 * Check request method.
 */

if ($_SERVER["REQUEST_METHOD"] !== "POST") {

    header("Location: index.php");

    exit();

}


/*
 * Create log folder.
 */

$logFolder = "project_logs";

if (!is_dir($logFolder)) {

    if (!mkdir($logFolder, 0777, true)) {

        $_SESSION["error"] =
            "Unable to create the project log folder.";

        header("Location: index.php");

        exit();

    }

}


/*
 * Receive form data.
 */

$projectName = trim(
    $_POST["project_name"] ?? ""
);

$memberName = trim(
    $_POST["member_name"] ?? ""
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
    $projectName === "" ||
    $memberName === "" ||
    $activity === "" ||
    $status === "" ||
    $description === ""
) {

    $_SESSION["error"] =
        "Please fill in all the required fields.";

    header("Location: index.php");

    exit();

}


/*
 * Validate names.
 */

if (!preg_match(
    "/^[a-zA-Z0-9 .&'-]+$/",
    $projectName
)) {

    $_SESSION["error"] =
        "Please enter a valid project name.";

    header("Location: index.php");

    exit();

}


if (!preg_match(
    "/^[a-zA-Z ]+$/",
    $memberName
)) {

    $_SESSION["error"] =
        "Team member name should contain only letters.";

    header("Location: index.php");

    exit();

}


/*
 * Get current date and time.
 */

$currentDate = date("d-m-Y");

$currentTime = date("h:i:s A");

$today = date("Y-m-d");


/*
 * Automatically create today's file.
 */

$logFile =
    $logFolder .
    "/project_log_" .
    $today .
    ".txt";


/*
 * Prepare log entry.
 */

$logEntry =
    "Date: " . $currentDate .
    " | Time: " . $currentTime .
    " | Project: " . $projectName .
    " | Member: " . $memberName .
    " | Activity: " . $activity .
    " | Status: " . $status .
    " | Work: " . $description;


/*
 * Append the log entry to today's file.
 */

$result = file_put_contents(
    $logFile,
    $logEntry . PHP_EOL,
    FILE_APPEND | LOCK_EX
);


/*
 * Display result.
 */

if ($result === false) {

    $_SESSION["error"] =
        "Unable to save the project log.";

} else {

    $_SESSION["success"] =
        "Project log saved successfully.";

}


/*
 * Return to main page.
 */

header("Location: index.php");

exit();

?>