<?php


$allowedFolders = [

    "academic",
    "finance",
    "attendance"

];


// Check folder

$folder = $_GET["folder"] ?? "";

$file = $_GET["file"] ?? "";


if (
    !in_array($folder, $allowedFolders)
) {

    header(
        "Location: index.php?message=Invalid report folder.&type=error"
    );

    exit();

}


// Check file name

if ($file === "") {

    header(
        "Location: index.php?message=Please select a report.&type=error"
    );

    exit();

}


// Prevent directory traversal

$file = basename($file);


// Create full path

$filePath =
    $folder .
    "/" .
    $file;


// Check whether file exists

if (!is_file($filePath)) {

    header(
        "Location: index.php?message=Selected report was not found.&type=error"
    );

    exit();

}


// Read file

$content = file_get_contents($filePath);


// Check file reading

if ($content === false) {

    header(
        "Location: index.php?message=Unable to access the selected report.&type=error"
    );

    exit();

}

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
        View Report
    </title>

    <link rel="stylesheet" href="style.css">

</head>

<body>

<div class="container">

    <header>

        <div class="main-icon">
            📋
        </div>

        <h1>
            Report Viewer
        </h1>

        <p>
            Selected report details
        </p>

    </header>


    <main>

        <section class="report-view">

            <div class="report-header">

                <div class="report-icon">
                    📄
                </div>

                <div>

                    <h2>

                        <?= htmlspecialchars($file) ?>

                    </h2>

                    <p>

                        Category:
                        <?= htmlspecialchars($folder) ?>

                    </p>

                </div>

            </div>


            <div class="report-content">

                <?= nl2br(htmlspecialchars($content)) ?>

            </div>


            <a
                href="index.php"
                class="back-button"
            >

                ← Back to Reports

            </a>

        </section>

    </main>


    <footer>

        Report File Access System

    </footer>

</div>

</body>

</html>