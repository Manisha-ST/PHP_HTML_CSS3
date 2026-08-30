<?php


$resumeFolder = "resumes";


// Create folder if it does not exist

if (!is_dir($resumeFolder)) {

    mkdir($resumeFolder);

}


// Allow only POST requests

if ($_SERVER["REQUEST_METHOD"] !== "POST") {

    header("Location: index.php");

    exit();

}


// Get applicant name

$applicant = trim(
    $_POST["applicant"] ?? ""
);


// Validate applicant name

if ($applicant === "") {

    header(
        "Location: index.php?message=Please enter your name.&type=error"
    );

    exit();

}


// Check uploaded resume

if (
    !isset($_FILES["resume"]) ||
    $_FILES["resume"]["error"] !== UPLOAD_ERR_OK
) {

    header(
        "Location: index.php?message=Please select a resume file.&type=error"
    );

    exit();

}


$resume = $_FILES["resume"];


// Get original filename

$originalName = basename(
    $resume["name"]
);


// Get extension

$extension = strtolower(
    pathinfo(
        $originalName,
        PATHINFO_EXTENSION
    )
);


// Allowed extensions

$allowedExtensions = [

    "pdf",
    "doc",
    "docx"

];


// Validate extension

if (!in_array(
    $extension,
    $allowedExtensions
)) {

    header(
        "Location: index.php?message=Invalid file type. Only PDF, DOC and DOCX files are allowed.&type=error"
    );

    exit();

}


// Maximum file size = 5 MB

$maxSize = 5 * 1024 * 1024;


if ($resume["size"] > $maxSize) {

    header(
        "Location: index.php?message=Invalid file. Resume size must not exceed 5 MB.&type=error"
    );

    exit();

}


// Check that uploaded file is valid

if (!is_uploaded_file(
    $resume["tmp_name"]
)) {

    header(
        "Location: index.php?message=Invalid file submission detected.&type=error"
    );

    exit();

}


// Create safe applicant name

$safeApplicant = preg_replace(
    "/[^a-zA-Z0-9_-]/",
    "_",
    $applicant
);


// Create unique filename

$newFileName =
    $safeApplicant .
    "_resume_" .
    time() .
    "." .
    $extension;


$destination =
    $resumeFolder .
    "/" .
    $newFileName;


// Move file to resume folder

if (
    move_uploaded_file(
        $resume["tmp_name"],
        $destination
    )
) {

    header(
        "Location: index.php?message=Resume uploaded and validated successfully.&type=success"
    );

    exit();

}


// Upload failed

header(
    "Location: index.php?message=Unable to upload the resume.&type=error"
);

exit();

?>