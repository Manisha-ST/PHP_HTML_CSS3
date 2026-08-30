<?php

session_start();

$studentFile = "student_records.txt";

$records = [];

if (file_exists($studentFile)) {

    $records = file(
        $studentFile,
        FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES
    );
}

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

    <title>Student Records File Update</title>

    <link rel="stylesheet" href="style.css">

</head>

<body>

<div class="page">

    <header>

        <div class="header-icon">
            📚
        </div>

        <h1>Student Records</h1>

        <p>
            File-Based Student Record Management System
        </p>

    </header>


    <main>


        <?php if ($successMessage !== ""): ?>

            <div class="message success">

                <span>✓</span>

                <?= htmlspecialchars($successMessage) ?>

            </div>

        <?php endif; ?>


        <?php if ($errorMessage !== ""): ?>

            <div class="message error">

                <span>!</span>

                <?= htmlspecialchars($errorMessage) ?>

            </div>

        <?php endif; ?>


        <!-- ADD RECORD -->

        <section class="form-section">

            <div class="section-title">

                <span class="number">
                    01
                </span>

                <div>

                    <h2>
                        Add Student Record
                    </h2>

                    <p>
                        Enter the student's details below.
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
                    value="add"
                >


                <div class="input-grid">


                    <div class="input-group">

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


                    <div class="input-group">

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


                    <div class="input-group">

                        <label for="course">
                            Course
                        </label>

                        <select
                            id="course"
                            name="course"
                            required
                        >

                            <option value="">
                                Select course
                            </option>

                            <option value="B.Sc Computer Science">
                                B.Sc Computer Science
                            </option>

                            <option value="BCA">
                                BCA
                            </option>

                            <option value="B.Sc IT">
                                B.Sc IT
                            </option>

                            <option value="B.Com">
                                B.Com
                            </option>

                        </select>

                    </div>


                    <div class="input-group">

                        <label for="year">
                            Year
                        </label>

                        <select
                            id="year"
                            name="year"
                            required
                        >

                            <option value="">
                                Select year
                            </option>

                            <option value="I Year">
                                I Year
                            </option>

                            <option value="II Year">
                                II Year
                            </option>

                            <option value="III Year">
                                III Year
                            </option>

                        </select>

                    </div>


                    <div class="input-group">

                        <label for="email">
                            Email
                        </label>

                        <input
                            type="email"
                            id="email"
                            name="email"
                            placeholder="student@example.com"
                            required
                        >

                    </div>


                    <div class="input-group">

                        <label for="phone">
                            Phone Number
                        </label>

                        <input
                            type="tel"
                            id="phone"
                            name="phone"
                            placeholder="10-digit phone number"
                            pattern="[0-9]{10}"
                            required
                        >

                    </div>

                </div>


                <button
                    type="submit"
                    class="add-button"
                >

                    + Add Student Record

                </button>

            </form>

        </section>


        <!-- RECORD SUMMARY -->

        <section class="summary">

            <div class="summary-card">

                <div class="summary-icon">
                    👨‍🎓
                </div>

                <div>

                    <span>
                        Total Student Records
                    </span>

                    <strong>
                        <?= count($records) ?>
                    </strong>

                </div>

            </div>


            <div class="summary-card">

                <div class="summary-icon">
                    📄
                </div>

                <div>

                    <span>
                        Storage File
                    </span>

                    <strong>
                        student_records.txt
                    </strong>

                </div>

            </div>

        </section>


        <!-- UPDATED RECORDS -->

        <section class="records-section">

            <div class="records-heading">

                <div>

                    <h2>
                        Updated Student Records
                    </h2>

                    <p>
                        All records currently stored in the file.
                    </p>

                </div>

                <div class="record-count">
                    <?= count($records) ?> Records
                </div>

            </div>


            <?php if (empty($records)): ?>

                <div class="empty">

                    <div class="empty-icon">
                        📂
                    </div>

                    <h3>
                        No Student Records
                    </h3>

                    <p>
                        Add a student record using the form above.
                    </p>

                </div>

            <?php else: ?>


                <div class="records-list">

                    <?php

                    $displayRecords = array_reverse($records);

                    foreach ($displayRecords as $index => $record):

                    ?>

                        <div class="record-card">

                            <div class="student-number">

                                <?= count($records) - $index ?>

                            </div>

                            <div class="record-content">

                                <?= htmlspecialchars($record) ?>

                            </div>

                        </div>

                    <?php endforeach; ?>

                </div>

            <?php endif; ?>

        </section>


        <!-- FILE INFORMATION -->

        <section class="file-info">

            <div class="file-icon">
                💾
            </div>

            <div>

                <h3>
                    File Storage Information
                </h3>

                <p>
                    New student records are appended to
                    <strong>student_records.txt</strong>.
                    Existing records are preserved and the
                    updated contents are displayed above.
                </p>

            </div>

        </section>

    </main>


    <footer>

        <p>
            Student Records File Update System
        </p>

    </footer>

</div>

</body>

</html>