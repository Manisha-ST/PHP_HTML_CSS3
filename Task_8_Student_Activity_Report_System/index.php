<?php

session_start();

/*
 * Create session activity list if it does not exist.
 */

if (!isset($_SESSION["activities"])) {
    $_SESSION["activities"] = [];
}

/*
 * Activity file.
 */

$activityFile = "student_activities.txt";

/*
 * Read existing activities from file.
 */

$fileActivities = [];

if (file_exists($activityFile)) {

    $fileActivities = file(
        $activityFile,
        FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES
    );
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

    <title>Student Activity Report</title>

    <link rel="stylesheet" href="style.css">

</head>

<body>

<div class="container">

    <header>

        <div class="header-icon">
            🎓
        </div>

        <h1>Student Activity Report</h1>

        <p>
            Student Activity Tracking and Summary System
        </p>

    </header>


    <main>


        <!-- ACTIVITY FORM -->

        <section class="form-card">

            <div class="title-area">

                <h2>
                    Add Student Activity
                </h2>

                <p>
                    Enter the details of the student's activity.
                </p>

            </div>


            <form
                action="process.php"
                method="POST"
            >

                <input
                    type="hidden"
                    name="action"
                    value="add"
                >


                <div class="form-row">


                    <div class="form-group">

                        <label for="student_name">
                            Student Name
                        </label>

                        <input
                            type="text"
                            id="student_name"
                            name="student_name"
                            placeholder="Enter student name"
                            required
                        >

                    </div>


                    <div class="form-group">

                        <label for="register_number">
                            Register Number
                        </label>

                        <input
                            type="text"
                            id="register_number"
                            name="register_number"
                            placeholder="Enter register number"
                            required
                        >

                    </div>

                </div>


                <div class="form-row">


                    <div class="form-group">

                        <label for="activity">
                            Activity
                        </label>

                        <select
                            id="activity"
                            name="activity"
                            required
                        >

                            <option value="">
                                Select Activity
                            </option>

                            <option value="Assignment">
                                Assignment
                            </option>

                            <option value="Seminar">
                                Seminar
                            </option>

                            <option value="Project">
                                Project
                            </option>

                            <option value="Workshop">
                                Workshop
                            </option>

                            <option value="Sports">
                                Sports
                            </option>

                            <option value="Quiz">
                                Quiz
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
                                Select Status
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
                        Activity Description
                    </label>

                    <textarea
                        id="description"
                        name="description"
                        rows="4"
                        placeholder="Enter activity details"
                        required
                    ></textarea>

                </div>


                <button type="submit">
                    Add Activity
                </button>

            </form>

        </section>


        <!-- SESSION SUMMARY -->

        <section class="summary-section">

            <div class="summary-card">

                <div class="summary-icon">
                    📊
                </div>

                <div>

                    <span>
                        Session Activities
                    </span>

                    <strong>
                        <?= count($_SESSION["activities"]) ?>
                    </strong>

                </div>

            </div>


            <div class="summary-card">

                <div class="summary-icon">
                    📁
                </div>

                <div>

                    <span>
                        Stored Records
                    </span>

                    <strong>
                        <?= count($fileActivities) ?>
                    </strong>

                </div>

            </div>

        </section>


        <!-- CURRENT SESSION ACTIVITIES -->

        <section class="activity-section">

            <div class="section-heading">

                <h2>
                    📋 Current Session Activities
                </h2>

                <p>
                    Activities recorded during this session.
                </p>

            </div>


            <?php if (empty($_SESSION["activities"])): ?>

                <div class="empty-box">

                    <div>
                        📝
                    </div>

                    <p>
                        No activities added yet.
                    </p>

                </div>

            <?php else: ?>


                <div class="table-container">

                    <table>

                        <thead>

                            <tr>

                                <th>
                                    Student
                                </th>

                                <th>
                                    Register No.
                                </th>

                                <th>
                                    Activity
                                </th>

                                <th>
                                    Status
                                </th>

                                <th>
                                    Date & Time
                                </th>

                            </tr>

                        </thead>


                        <tbody>

                        <?php foreach (
                            array_reverse($_SESSION["activities"])
                            as $activity
                        ): ?>

                            <tr>

                                <td>
                                    <?= htmlspecialchars(
                                        $activity["student_name"]
                                    ) ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars(
                                        $activity["register_number"]
                                    ) ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars(
                                        $activity["activity"]
                                    ) ?>
                                </td>

                                <td>

                                    <span class="status">

                                        <?= htmlspecialchars(
                                            $activity["status"]
                                        ) ?>

                                    </span>

                                </td>

                                <td>
                                    <?= htmlspecialchars(
                                        $activity["date"]
                                    ) ?>
                                </td>

                            </tr>

                        <?php endforeach; ?>

                        </tbody>

                    </table>

                </div>

            <?php endif; ?>

        </section>


        <!-- STORED FILE RECORDS -->

        <section class="file-section">

            <div class="section-heading">

                <h2>
                    📁 Stored Activity Records
                </h2>

                <p>
                    Activity information retrieved from the file.
                </p>

            </div>


            <?php if (empty($fileActivities)): ?>

                <div class="empty-box">

                    <div>
                        📂
                    </div>

                    <p>
                        No stored records available.
                    </p>

                </div>

            <?php else: ?>


                <div class="stored-records">

                    <?php foreach (
                        array_reverse($fileActivities)
                        as $record
                    ): ?>

                        <div class="record">

                            <?= htmlspecialchars($record) ?>

                        </div>

                    <?php endforeach; ?>

                </div>

            <?php endif; ?>

        </section>


        <!-- REPORT -->

        <section class="report-section">

            <h2>
                📈 Student Activity Summary
            </h2>

            <p>
                The system records student activities and generates
                activity information based on the stored records.
            </p>

            <div class="report-info">

                <div>
                    <strong>
                        <?= count($_SESSION["activities"]) ?>
                    </strong>

                    <span>
                        Current Session Records
                    </span>
                </div>


                <div>
                    <strong>
                        <?= count($fileActivities) ?>
                    </strong>

                    <span>
                        Total Stored Records
                    </span>
                </div>


                <div>
                    <strong>
                        <?= date("d") ?>
                    </strong>

                    <span>
                        Current Day
                    </span>
                </div>


                <div>
                    <strong>
                        <?= date("M") ?>
                    </strong>

                    <span>
                        Current Month
                    </span>
                </div>

            </div>

        </section>

    </main>


    <footer>

        <p>
            Student Activity Report System
        </p>

    </footer>

</div>

</body>

</html>