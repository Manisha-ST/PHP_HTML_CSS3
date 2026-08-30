<?php

session_start();


// Secure document folder

$documentFolder = "secure_documents";


// Create folder if required

if (!is_dir($documentFolder)) {

    mkdir($documentFolder);

}


// Allowed file types

$allowedExtensions = [

    "pdf",
    "doc",
    "docx",
    "txt"

];


// Maximum file size

$maxSize = 5 * 1024 * 1024;


// --------------------------------------------------
// VIEW DOCUMENT
// --------------------------------------------------

if (
    isset($_GET["action"]) &&
    $_GET["action"] === "view"
) {


    $file = basename(
        $_GET["file"] ?? ""
    );


    if ($file === "") {

        header(
            "Location: index.php?message=Invalid file.&type=error"
        );

        exit();

    }


    $filePath =
        $documentFolder .
        "/" .
        $file;


    // Check file exists

    if (!is_file($filePath)) {

        header(
            "Location: index.php?message=Document not found.&type=error"
        );

        exit();

    }


    // Get extension

    $extension = strtolower(
        pathinfo(
            $file,
            PATHINFO_EXTENSION
        )
    );


    // Check allowed extension

    if (!in_array(
        $extension,
        $allowedExtensions
    )) {

        header(
            "Location: index.php?message=Unauthorized file type.&type=error"
        );

        exit();

    }


    // Display text files

    if ($extension === "txt") {

        $content = file_get_contents(
            $filePath
        );

        ?>

        <!DOCTYPE html>

        <html lang="en">

        <head>

            <meta charset="UTF-8">

            <meta
                name="viewport"
                content="width=device-width, initial-scale=1.0"
            >

            <title>
                Secure Document
            </title>

            <link rel="stylesheet" href="style.css">

        </head>

        <body>

        <div class="container">

            <header>

                <div class="icon">
                    🔐
                </div>

                <h1>
                    Secure Document Viewer
                </h1>

                <p>
                    Authorized document access
                </p>

            </header>


            <main>

                <section class="viewer">

                    <div class="viewer-title">

                        📄

                        <h2>
                            <?= htmlspecialchars($file) ?>
                        </h2>

                    </div>


                    <div class="content">

                        <?= nl2br(
                            htmlspecialchars($content)
                        ) ?>

                    </div>


                    <a
                        href="index.php"
                        class="back"
                    >

                        ← Back to Documents

                    </a>

                </section>

            </main>


            <footer>

                Secure Document Management System

            </footer>

        </div>

        </body>

        </html>

        <?php

        exit();

    }


    // For PDF/DOC/DOCX files,
    // allow browser to open the file

    $mimeTypes = [

        "pdf" =>
            "application/pdf",

        "doc" =>
            "application/msword",

        "docx" =>
            "application/vnd.openxmlformats-officedocument.wordprocessingml.document"

    ];


    header(
        "Content-Type: " .
        $mimeTypes[$extension]
    );


    header(
        "Content-Disposition: inline; filename=\"" .
        basename($file) .
        "\""
    );


    readfile($filePath);

    exit();

}



// --------------------------------------------------
// POST OPERATIONS
// --------------------------------------------------

if ($_SERVER["REQUEST_METHOD"] !== "POST") {

    header("Location: index.php");

    exit();

}


$action = $_POST["action"] ?? "";


// --------------------------------------------------
// UPLOAD DOCUMENT
// --------------------------------------------------

if ($action === "upload") {


    if (
        !isset($_FILES["document"]) ||
        $_FILES["document"]["error"] !== UPLOAD_ERR_OK
    ) {

        header(
            "Location: index.php?message=Please select a document.&type=error"
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


    // Validate extension

    if (!in_array(
        $extension,
        $allowedExtensions
    )) {

        header(
            "Location: index.php?message=Invalid file type. Upload only PDF, DOC, DOCX or TXT files.&type=error"
        );

        exit();

    }


    // Validate file size

    if ($file["size"] > $maxSize) {

        header(
            "Location: index.php?message=File is too large. Maximum size is 5 MB.&type=error"
        );

        exit();

    }


    // Check valid upload

    if (!is_uploaded_file(
        $file["tmp_name"]
    )) {

        header(
            "Location: index.php?message=Unauthorized upload detected.&type=error"
        );

        exit();

    }


    // Clean filename

    $nameWithoutExtension =
        pathinfo(
            $originalName,
            PATHINFO_FILENAME
        );


    $safeName = preg_replace(
        "/[^a-zA-Z0-9_-]/",
        "_",
        $nameWithoutExtension
    );


    $newFileName =
        $safeName .
        "." .
        $extension;


    $destination =
        $documentFolder .
        "/" .
        $newFileName;


    // Prevent duplicate uploads

    if (file_exists($destination)) {

        header(
            "Location: index.php?message=Duplicate file upload prevented. This document already exists.&type=error"
        );

        exit();

    }


    // Move file

    if (
        move_uploaded_file(
            $file["tmp_name"],
            $destination
        )
    ) {

        header(
            "Location: index.php?message=Document uploaded securely.&type=success"
        );

        exit();

    }


    header(
        "Location: index.php?message=Document upload failed.&type=error"
    );

    exit();

}



// --------------------------------------------------
// DELETE DOCUMENT
// --------------------------------------------------

if ($action === "delete") {


    $filename = basename(
        $_POST["filename"] ?? ""
    );


    if ($filename === "") {

        header(
            "Location: index.php?message=Invalid document.&type=error"
        );

        exit();

    }


    $filePath =
        $documentFolder .
        "/" .
        $filename;


    if (!is_file($filePath)) {

        header(
            "Location: index.php?message=Document not found.&type=error"
        );

        exit();

    }


    if (unlink($filePath)) {

        header(
            "Location: index.php?message=Document deleted successfully.&type=success"
        );

        exit();

    }


    header(
        "Location: index.php?message=Unable to delete document.&type=error"
    );

    exit();

}


// Invalid operation

header(
    "Location: index.php?message=Invalid operation.&type=error"
);

exit();

?>