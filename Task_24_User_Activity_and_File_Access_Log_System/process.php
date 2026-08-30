<?php

session_start();

$logFile = "activity_log.txt";


// Create log file

if (!file_exists($logFile)) {

    file_put_contents($logFile, "");

}


// Set username

if (!isset($_SESSION["username"])) {

    $_SESSION["username"] = "Manisha";

}


$username = $_SESSION["username"];


// --------------------------------------------------
// FILE ACCESS
// --------------------------------------------------

if (
    $_SERVER["REQUEST_METHOD"] === "POST" &&
    ($_POST["action"] ?? "") === "access"
) {

    $filename = trim(
        $_POST["filename"] ?? ""
    );


    if ($filename === "") {

        header(
            "Location: index.php?message=Please select a file.&type=error"
        );

        exit();

    }


    // Allowed files

    $allowedFiles = [

        "Student_Record.pdf",
        "Attendance_Report.xlsx",
        "Project_Report.docx",
        "Mark_Sheet.pdf"

    ];


    if (!in_array(
        $filename,
        $allowedFiles
    )) {

        header(
            "Location: index.php?message=Unauthorized file access.&type=error"
        );

        exit();

    }


    $dateTime = date(
        "d-m-Y H:i:s"
    );


    $logEntry =
        $username .
        "|FILE ACCESS|" .
        $filename .
        "|" .
        $dateTime .
        PHP_EOL;


    file_put_contents(
        $logFile,
        $logEntry,
        FILE_APPEND | LOCK_EX
    );


    // Update cookie

    setcookie(
        "last_login",
        $dateTime,
        time() + (86400 * 30)
    );


    header(
        "Location: index.php?message=File access recorded successfully.&type=success"
    );

    exit();

}



// --------------------------------------------------
// CLEAR LOG
// --------------------------------------------------

if (
    $_SERVER["REQUEST_METHOD"] === "POST" &&
    ($_POST["action"] ?? "") === "clear"
) {


    file_put_contents(
        $logFile,
        ""
    );


    header(
        "Location: index.php?message=Activity log cleared successfully.&type=success"
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