<?php


$documentFolder = "documents";


// Create folder if required

if (!is_dir($documentFolder)) {

    mkdir($documentFolder);

}


// Allow only POST requests

if ($_SERVER["REQUEST_METHOD"] !== "POST") {

    header("Location: index.php");

    exit();

}


$action = $_POST["action"] ?? "";



/*
 * UPLOAD DOCUMENT
 */

if ($action === "upload") {


    if (
        !isset($_FILES["document"]) ||
        $_FILES["document"]["error"] !== UPLOAD_ERR_OK
    ) {

        header(
            "Location: index.php?message=Please select a document to upload.&type=error"
        );

        exit();

    }


    $file = $_FILES["document"];


    $originalName = basename(
        $file["name"]
    );


    $extension = strtolower(
        pathinfo(
            $originalName,
            PATHINFO_EXTENSION
        )
    );


    /*
     * Allowed file types
     */

    $allowedTypes = [

        "pdf",
        "doc",
        "docx",
        "txt"

    ];


    if (!in_array(
        $extension,
        $allowedTypes
    )) {

        header(
            "Location: index.php?message=Invalid file type. Only PDF, DOC, DOCX and TXT files are allowed.&type=error"
        );

        exit();

    }


    /*
     * File size limit
     * 10 MB
     */

    if ($file["size"] > 10 * 1024 * 1024) {

        header(
            "Location: index.php?message=File size must not exceed 10 MB.&type=error"
        );

        exit();

    }


    /*
     * Create safe filename
     */

    $fileName = pathinfo(
        $originalName,
        PATHINFO_FILENAME
    );


    $fileName = preg_replace(
        "/[^a-zA-Z0-9_-]/",
        "_",
        $fileName
    );


    $newFileName =
        $fileName .
        "_" .
        time() .
        "." .
        $extension;


    $destination =
        $documentFolder .
        "/" .
        $newFileName;


    /*
     * Move uploaded file
     */

    if (
        move_uploaded_file(
            $file["tmp_name"],
            $destination
        )
    ) {

        header(
            "Location: index.php?message=Document uploaded successfully.&type=success"
        );

        exit();

    }


    header(
        "Location: index.php?message=Document upload failed.&type=error"
    );

    exit();

}



/*
 * DELETE DOCUMENT
 */

if ($action === "delete") {


    $filename = basename(
        $_POST["filename"] ?? ""
    );


    if ($filename === "") {

        header(
            "Location: index.php?message=Invalid document name.&type=error"
        );

        exit();

    }


    $filePath =
        $documentFolder .
        "/" .
        $filename;


    /*
     * Check that file exists
     */

    if (!is_file($filePath)) {

        header(
            "Location: index.php?message=Document was not found.&type=error"
        );

        exit();

    }


    /*
     * Delete file
     */

    if (unlink($filePath)) {

        header(
            "Location: index.php?message=Document deleted successfully.&type=success"
        );

        exit();

    }


    header(
        "Location: index.php?message=Unable to delete the document.&type=error"
    );

    exit();

}



/*
 * Invalid operation
 */

header(
    "Location: index.php?message=Invalid operation.&type=error"
);

exit();

?>