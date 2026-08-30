<?php

session_start();

$logFolder = "project_logs";

/*
 * Create the project log folder if it does not exist.
 */

if (!is_dir($logFolder)) {
    mkdir($logFolder, 0777, true);
}


/*
 * Get today's log file name.
 */

$today = date("Y-m-d");

$todayFile = $logFolder . "/project_log_" . $today . ".txt";


/*
 * Read today's existing log entries.
 */

$logEntries = [];

if (file_exists($todayFile)) {

    $logEntries = file(
        $todayFile,
        FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES
    );
}


/*
 * Get messages.
 */

$successMessage = $_SESSION["success"] ?? "";
$errorMessage = $_SESSION["error"] ?? "";

unset($_SESSION["success"]);
unset($_SESSION["error"]);

?>

<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Daily Project Log Generator</title>

    <link rel="stylesheet" href="style.css">

</head>

<body>

<div class="container">

    <!-- HEADER -->

    <header>

        <div class="icon">
            🗓️
        </div>

        <h1>
            Daily Project Log
        </h1>

        <p>
            Record and manage your daily project activities
        </p>

    </header>


    <main>

        <!-- MESSAGES -->

        <?php if ($successMessage): ?>

            <div class="message success">

                ✓

                <?= htmlspecialchars($successMessage) ?>

            </div>

        <?php endif; ?>


        <?php if ($errorMessage): ?>

            <div class="message error">

                !

                <?= htmlspecialchars($errorMessage) ?>

            </div>

        <?php endif; ?>


        <!-- DATE DISPLAY -->

        <section class="date-card">

            <div>

                <span class="label">
                    TODAY'S DATE
                </span>

                <h2>
                    <?= date("d F Y") ?>
                </h2>

            </div>

            <div class="time">

                <span class="label">
                    CURRENT TIME
                </span>

                <strong>
                    <?= date("h:i A") ?>
                </strong>

            </div>

        </section>


        <!-- LOG FORM -->

        <section class="form-card">

            <h2>
                Add Project Log
            </h2>

            <p class="subtitle">
                Enter the details of today's project activity.
            </p>


            <form
                action="process.php"
                method="POST"
            >

                <div class="form-grid">


                    <div class="form-group">

                        <label for="project_name">
                            Project Name
                        </label>

                        <input
                            type="text"
                            id="project_name"
                            name="project_name"
                            placeholder="Enter project name"
                            required
                        >

                    </div>


                    <div class="form-group">

                        <label for="member_name">
                            Team Member
                        </label>

                        <input
                            type="text"
                            id="member_name"
                            name="member_name"
                            placeholder="Enter member name"
                            required
                        >

                    </div>


                    <div class="form-group">

                        <label for="activity">
                            Activity Type
                        </label>

                        <select
                            id="activity"
                            name="activity"
                            required
                        >

                            <option value="">
                                Select activity
                            </option>

                            <option value="Planning">
                                Planning
                            </option>

                            <option value="Development">
                                Development
                            </option>

                            <option value="Testing">
                                Testing
                            </option>

                            <option value="Documentation">
                                Documentation
                            </option>

                            <option value="Meeting">
                                Meeting
                            </option>

                            <option value="Research">
                                Research
                            </option>

                        </select>

                    </div>


                    <div class="form-group">

                        <label for="status">
                            Status
                        </label>

                        <select
                            id="status"
                            name="status"
                            required
                        >

                            <option value="">
                                Select status
                            </option>

                            <option value="Completed">
                                Completed
                            </option>

                            <option value="In Progress">
                                In Progress
                            </option>

                            <option value="Pending">
                                Pending
                            </option>

                        </select>

                    </div>

                </div>


                <div class="form-group">

                    <label for="description">
                        Work Description
                    </label>

                    <textarea
                        id="description"
                        name="description"
                        rows="5"
                        placeholder="Describe the work completed today..."
                        required
                    ></textarea>

                </div>


                <button type="submit">

                    + Save Today's Log

                </button>

            </form>

        </section>


        <!-- TODAY'S LOG -->

        <section class="logs-section">

            <div class="section-heading">

                <div>

                    <h2>
                        Today's Project Logs
                    </h2>

                    <p>
                        Entries saved in today's automatically generated log file.
                    </p>

                </div>

                <div class="count">

                    <?= count($logEntries) ?>

                    Entries

                </div>

            </div>


            <?php if (empty($logEntries)): ?>

                <div class="empty">

                    <div>
                        📝
                    </div>

                    <h3>
                        No Logs Added Yet
                    </h3>

                    <p>
                        Add your first project activity above.
                    </p>

                </div>

            <?php else: ?>


                <div class="logs">

                    <?php foreach (
                        array_reverse($logEntries)
                        as $entry
                    ): ?>

                        <div class="log-entry">

                            <span class="dot">
                                ●
                            </span>

                            <div>

                                <?= htmlspecialchars($entry) ?>

                            </div>

                        </div>

                    <?php endforeach; ?>

                </div>

            <?php endif; ?>

        </section>


        <!-- FILE DETAILS -->

        <section class="file-card">

            <div class="file-icon">
                📁
            </div>

            <div>

                <h3>
                    Today's Log File
                </h3>

                <p>

                    <?= htmlspecialchars($todayFile) ?>

                </p>

                <small>
                    A new log file is automatically created for each day.
                </small>

            </div>

        </section>

    </main>


    <footer>

        Daily Project Log Generator

    </footer>

</div>

</body>

</html>