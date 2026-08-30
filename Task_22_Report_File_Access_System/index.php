<?php

$reportFolders = [
    "academic" => "Academic Reports",
    "finance" => "Finance Reports",
    "attendance" => "Attendance Reports"
];


// Create folders and sample files

foreach ($reportFolders as $folder => $title) {

    if (!is_dir($folder)) {

        mkdir($folder);

    }

}


// Create sample reports if folders are empty

if (count(scandir("academic")) == 2) {

    file_put_contents(
        "academic/student_performance.txt",
        "Student Performance Report\n\n"
        . "This report contains academic performance details.\n"
        . "Department: Computer Science\n"
        . "Semester: III\n"
        . "Status: Good"
    );

}

if (count(scandir("finance")) == 2) {

    file_put_contents(
        "finance/fee_report.txt",
        "Fee Payment Report\n\n"
        . "This report contains student fee payment information.\n"
        . "Payment Status: Completed\n"
        . "Academic Year: 2026"
    );

}

if (count(scandir("attendance")) == 2) {

    file_put_contents(
        "attendance/attendance_report.txt",
        "Attendance Report\n\n"
        . "This report contains student attendance information.\n"
        . "Attendance Status: Regular\n"
        . "Semester: III"
    );

}


// Message

$message = $_GET["message"] ?? "";

$type = $_GET["type"] ?? "";

?>

<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Report File Access System</title>

    <link rel="stylesheet" href="style.css">

</head>

<body>

<div class="container">

    <header>

        <div class="main-icon">
            📊
        </div>

        <h1>
            Report File Access System
        </h1>

        <p>
            Store, view and manage reports using PHP directories
        </p>

    </header>


    <main>

        <?php if ($message != ""): ?>

            <div class="message <?= htmlspecialchars($type) ?>">

                <?= htmlspecialchars($message) ?>

            </div>

        <?php endif; ?>


        <section class="intro">

            <div class="intro-icon">
                📁
            </div>

            <div>

                <h2>
                    Available Report Categories
                </h2>

                <p>
                    Select a report category to view the available files.
                </p>

            </div>

        </section>


        <div class="category-grid">

            <?php foreach ($reportFolders as $folder => $title): ?>

                <?php

                $files = [];

                $folderFiles = scandir($folder);

                foreach ($folderFiles as $file) {

                    if (
                        $file != "." &&
                        $file != ".." &&
                        is_file($folder . "/" . $file)
                    ) {

                        $files[] = $file;

                    }

                }

                ?>


                <section class="category-card">

                    <div class="category-icon">

                        <?php

                        if ($folder == "academic") {

                            echo "🎓";

                        } elseif ($folder == "finance") {

                            echo "💰";

                        } else {

                            echo "📅";

                        }

                        ?>

                    </div>


                    <h2>

                        <?= htmlspecialchars($title) ?>

                    </h2>


                    <p class="folder-name">

                        Folder:
                        <?= htmlspecialchars($folder) ?>

                    </p>


                    <div class="file-count">

                        <?= count($files) ?> Report(s)

                    </div>


                    <div class="file-list">

                        <?php if (empty($files)): ?>

                            <p class="no-file">

                                No reports available.

                            </p>

                        <?php else: ?>

                            <?php foreach ($files as $file): ?>

                                <div class="file-row">

                                    <div class="file-details">

                                        <span class="file-icon">
                                            📄
                                        </span>

                                        <span>

                                            <?= htmlspecialchars($file) ?>

                                        </span>

                                    </div>


                                    <a
                                        href="process.php?folder=<?= urlencode($folder) ?>&file=<?= urlencode($file) ?>"
                                    >
                                        Open
                                    </a>

                                </div>

                            <?php endforeach; ?>

                        <?php endif; ?>

                    </div>

                </section>

            <?php endforeach; ?>

        </div>


        <section class="information">

            <h2>
                ℹ️ Report Access
            </h2>

            <p>
                Reports are organized into separate directories.
                PHP directory functions are used to identify and
                display the available files. Select the
                <strong>Open</strong> button to access a report.
            </p>

        </section>

    </main>


    <footer>

        Report File Access System

    </footer>

</div>

</body>

</html>