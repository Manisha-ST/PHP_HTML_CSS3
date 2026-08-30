<?php

session_start();


// File locations

$studentFile = "students.txt";

$backupFolder = "backups";


// Create backup folder if required

if (!is_dir($backupFolder)) {

    mkdir($backupFolder);

}


// Check request

if ($_SERVER["REQUEST_METHOD"] !== "POST") {

    header("Location: index.php");

    exit();

}


$action = $_POST["action"] ?? "";


if ($action === "backup") {


    // Check whether student file exists

    if (!file_exists($studentFile)) {

        $_SESSION["message"] =
            "Student record file was not found.";

        $_SESSION["type"] =
            "error";

        header("Location: index.php");

        exit();

    }


    // Generate timestamp

    $timestamp = date("Y-m-d_H-i-s");


    // Create backup filename

    $backupFile =
        $backupFolder .
        "/student_backup_" .
        $timestamp .
        ".txt";


    // Read original records

    $studentData = file_get_contents(
        $studentFile
    );


    // Add backup information

    $backupContent =
        "STUDENT RECORD BACKUP\n";

    $backupContent .=
        "Backup Date: " .
        date("d-m-Y") .
        "\n";

    $backupContent .=
        "Backup Time: " .
        date("h:i:s A") .
        "\n";

    $backupContent .=
        "--------------------------------\n";

    $backupContent .=
        $studentData;


    // Create backup file

    $result = file_put_contents(
        $backupFile,
        $backupContent
    );


    if ($result === false) {

        $_SESSION["message"] =
            "Backup could not be created.";

        $_SESSION["type"] =
            "error";

    } else {

        $_SESSION["message"] =
            "Backup created successfully at " .
            date("h:i:s A") .
            ".";

        $_SESSION["type"] =
            "success";

    }


    header("Location: index.php");

    exit();

}


// Invalid action

$_SESSION["message"] =
    "Invalid operation.";

$_SESSION["type"] =
    "error";

header("Location: index.php");

exit();

?>