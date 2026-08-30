<?php

session_start();

$logFile = "activity_log.txt";


// Create log file if it does not exist

if (!file_exists($logFile)) {

    file_put_contents($logFile, "");

}


// Start session

if (!isset($_SESSION["username"])) {

    $_SESSION["username"] = "Manisha";

}


// Store login information in cookie

if (!isset($_COOKIE["last_login"])) {

    setcookie(
        "last_login",
        date("d-m-Y H:i:s"),
        time() + (86400 * 30)
    );

}


// Read activity log

$activities = [];

$lines = file(
    $logFile,
    FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES
);

foreach ($lines as $line) {

    $parts = explode("|", $line);

    if (count($parts) >= 4) {

        $activities[] = $parts;

    }

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

    <title>
        User Activity Log System
    </title>

    <link rel="stylesheet" href="style.css">

</head>

<body>

<div class="container">

    <header>

        <div class="icon">
            📋
        </div>

        <h1>
            User Activity & File Access Log
        </h1>

        <p>
            Track login history and file access activities
        </p>

    </header>


    <main>

        <?php if ($message != ""): ?>

            <div class="message <?= htmlspecialchars($type) ?>">

                <?= htmlspecialchars($message) ?>

            </div>

        <?php endif; ?>


        <!-- USER INFORMATION -->

        <section class="user-card">

            <div class="user-icon">
                👤
            </div>

            <div>

                <h2>
                    Welcome,
                    <?= htmlspecialchars($_SESSION["username"]) ?>
                </h2>

                <p>
                    Session-based user activity tracking is active.
                </p>

            </div>

        </section>


        <!-- LOGIN INFORMATION -->

        <section class="login-card">

            <h2>
                🔐 Login Information
            </h2>

            <div class="login-info">

                <div>

                    <span>
                        Current User
                    </span>

                    <strong>
                        <?= htmlspecialchars($_SESSION["username"]) ?>
                    </strong>

                </div>


                <div>

                    <span>
                        Current Login
                    </span>

                    <strong>
                        <?= date("d M Y, h:i:s A") ?>
                    </strong>

                </div>


                <div>

                    <span>
                        Previous Login Cookie
                    </span>

                    <strong>

                        <?php

                        if (isset($_COOKIE["last_login"])) {

                            echo htmlspecialchars(
                                $_COOKIE["last_login"]
                            );

                        } else {

                            echo "First visit";

                        }

                        ?>

                    </strong>

                </div>

            </div>

        </section>


        <!-- FILE ACCESS -->

        <section class="access-card">

            <h2>
                📁 File Access
            </h2>

            <p>
                Select a file to record an access activity.
            </p>


            <form
                action="process.php"
                method="POST"
            >

                <input
                    type="hidden"
                    name="action"
                    value="access"
                >


                <select
                    name="filename"
                    required
                >

                    <option value="">
                        -- Select a file --
                    </option>

                    <option value="Student_Record.pdf">
                        Student_Record.pdf
                    </option>

                    <option value="Attendance_Report.xlsx">
                        Attendance_Report.xlsx
                    </option>

                    <option value="Project_Report.docx">
                        Project_Report.docx
                    </option>

                    <option value="Mark_Sheet.pdf">
                        Mark_Sheet.pdf
                    </option>

                </select>


                <button type="submit">

                    Record File Access

                </button>

            </form>

        </section>


        <!-- ACTIVITY REPORT -->

        <section class="activity-section">

            <div class="section-heading">

                <div>

                    <h2>
                        📊 User Activity Report
                    </h2>

                    <p>
                        Complete login and file access history.
                    </p>

                </div>

                <span class="count">

                    <?= count($activities) ?> Activities

                </span>

            </div>


            <?php if (empty($activities)): ?>

                <div class="empty">

                    <div class="empty-icon">
                        📭
                    </div>

                    <h3>
                        No Activity Recorded
                    </h3>

                    <p>
                        User activities will appear here.
                    </p>

                </div>

            <?php else: ?>

                <div class="table-container">

                    <table>

                        <thead>

                            <tr>

                                <th>
                                    User
                                </th>

                                <th>
                                    Activity
                                </th>

                                <th>
                                    File
                                </th>

                                <th>
                                    Date & Time
                                </th>

                            </tr>

                        </thead>


                        <tbody>

                            <?php foreach (
                                array_reverse($activities)
                                as $activity
                            ): ?>

                                <tr>

                                    <td>
                                        <?= htmlspecialchars($activity[0]) ?>
                                    </td>

                                    <td>

                                        <span class="activity-badge">

                                            <?= htmlspecialchars($activity[1]) ?>

                                        </span>

                                    </td>

                                    <td>
                                        <?= htmlspecialchars($activity[2]) ?>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars($activity[3]) ?>
                                    </td>

                                </tr>

                            <?php endforeach; ?>

                        </tbody>

                    </table>

                </div>

            <?php endif; ?>

        </section>


        <!-- CLEAR LOG -->

        <section class="clear-section">

            <form
                action="process.php"
                method="POST"
                onsubmit="return confirm('Clear all activity records?');"
            >

                <input
                    type="hidden"
                    name="action"
                    value="clear"
                >

                <button
                    type="submit"
                    class="clear-button"
                >

                    🗑 Clear Activity Log

                </button>

            </form>

        </section>

    </main>


    <footer>

        User Activity and File Access Log System

    </footer>

</div>

</body>

</html>