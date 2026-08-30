<?php

session_start();

$studentFile = "students.txt";
$backupFolder = "backups";


// Create student file if it does not exist

if (!file_exists($studentFile)) {

    file_put_contents(
        $studentFile,
        "24SBCS001|Ananya|B.Sc Computer Science|85\n" .
        "24SBCS002|Divya|B.Sc Computer Science|91\n" .
        "24SBCS003|Keerthana|B.Sc Computer Science|88\n"
    );

}


// Create backup folder if it does not exist

if (!is_dir($backupFolder)) {

    mkdir($backupFolder);

}


// Read student records

$records = file(
    $studentFile,
    FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES
);


// Read backup files

$backupFiles = [];

$files = scandir($backupFolder);

foreach ($files as $file) {

    if ($file != "." && $file != "..") {

        $backupFiles[] = $file;

    }

}


// Display message

$message = $_SESSION["message"] ?? "";

$type = $_SESSION["type"] ?? "";

unset($_SESSION["message"]);
unset($_SESSION["type"]);

?>

<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Student Records Backup</title>

    <link rel="stylesheet" href="style.css">

</head>

<body>

<div class="container">

    <header>

        <div class="backup-icon">
            💾
        </div>

        <h1>
            Student Records Backup
        </h1>

        <p>
            Manage student records and create secure backups
        </p>

    </header>


    <main>

        <?php if ($message != ""): ?>

            <div class="message <?= htmlspecialchars($type) ?>">

                <?= htmlspecialchars($message) ?>

            </div>

        <?php endif; ?>


        <section class="backup-panel">

            <div class="panel-title">

                <div class="title-icon">
                    🛡️
                </div>

                <div>

                    <h2>
                        Backup Management
                    </h2>

                    <p>
                        Create a timestamped backup of student records.
                    </p>

                </div>

            </div>


            <form
                action="process.php"
                method="POST"
            >

                <input
                    type="hidden"
                    name="action"
                    value="backup"
                >

                <button type="submit">

                    Create Backup Now

                </button>

            </form>


            <div class="backup-info">

                <div>

                    <strong>
                        Current Date
                    </strong>

                    <span>
                        <?= date("d M Y") ?>
                    </span>

                </div>


                <div>

                    <strong>
                        Current Time
                    </strong>

                    <span>
                        <?= date("h:i:s A") ?>
                    </span>

                </div>

            </div>

        </section>


        <section class="records">

            <div class="section-heading">

                <div>

                    <h2>
                        👨‍🎓 Student Records
                    </h2>

                    <p>
                        Digital student information stored in the system.
                    </p>

                </div>

                <span class="record-count">
                    <?= count($records) ?> Students
                </span>

            </div>


            <div class="table-wrapper">

                <table>

                    <thead>

                        <tr>

                            <th>
                                Student ID
                            </th>

                            <th>
                                Name
                            </th>

                            <th>
                                Course
                            </th>

                            <th>
                                Mark
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                    <?php foreach ($records as $record): ?>

                        <?php

                        $data = explode("|", $record);

                        ?>

                        <tr>

                            <td>
                                <?= htmlspecialchars($data[0] ?? "") ?>
                            </td>

                            <td class="student-name">
                                <?= htmlspecialchars($data[1] ?? "") ?>
                            </td>

                            <td>
                                <?= htmlspecialchars($data[2] ?? "") ?>
                            </td>

                            <td>
                                <?= htmlspecialchars($data[3] ?? "") ?>%
                            </td>

                        </tr>

                    <?php endforeach; ?>

                    </tbody>

                </table>

            </div>

        </section>


        <section class="backup-history">

            <div class="section-heading">

                <div>

                    <h2>
                        🕒 Backup History
                    </h2>

                    <p>
                        Previously created backup files.
                    </p>

                </div>

                <span class="backup-count">
                    <?= count($backupFiles) ?> Backups
                </span>

            </div>


            <?php if (empty($backupFiles)): ?>

                <div class="empty">

                    <div>
                        📂
                    </div>

                    <h3>
                        No backups created yet
                    </h3>

                    <p>
                        Click "Create Backup Now" to create the first backup.
                    </p>

                </div>

            <?php else: ?>

                <div class="backup-list">

                    <?php foreach ($backupFiles as $backup): ?>

                        <div class="backup-item">

                            <span class="file-icon">
                                📄
                            </span>

                            <div>

                                <strong>
                                    <?= htmlspecialchars($backup) ?>
                                </strong>

                                <p>
                                    Backup file created successfully
                                </p>

                            </div>

                        </div>

                    <?php endforeach; ?>

                </div>

            <?php endif; ?>

        </section>


        <div class="note">

            <strong>
                Backup Information
            </strong>

            <p>
                Every backup is saved with the current date
                and time so that previous student records
                can be identified easily.
            </p>

        </div>

    </main>


    <footer>

        Student Records Backup System

    </footer>

</div>

</body>

</html>