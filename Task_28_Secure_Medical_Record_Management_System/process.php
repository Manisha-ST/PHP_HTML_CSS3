<?php

session_start();


// Medical records file

$recordFile = "medical_records.txt";


// Create sample records if file does not exist

if (!file_exists($recordFile)) {

    $sampleRecords =
        "MR001|John Smith|35|General Medicine|Fever and routine check-up\n" .
        "MR002|Priya Kumar|28|Cardiology|Regular heart examination\n" .
        "MR003|Rahul Das|42|Orthopedics|Back pain consultation\n";

    file_put_contents(
        $recordFile,
        $sampleRecords
    );

}


// --------------------------------------------------
// LOGIN
// --------------------------------------------------

if (
    $_SERVER["REQUEST_METHOD"] === "POST" &&
    ($_POST["action"] ?? "") === "login"
) {


    $username =
        trim($_POST["username"] ?? "");


    $password =
        $_POST["password"] ?? "";


    if (
        $username === "" ||
        $password === ""
    ) {

        header(
            "Location: index.php?message=Please enter all login details.&type=error"
        );

        exit();

    }


    // Demo credentials

    $validUsername = "doctor";

    $validPassword = "medical123";


    if (
        $username === $validUsername &&
        $password === $validPassword
    ) {


        // Regenerate session ID

        session_regenerate_id(true);


        // Store authentication information

        $_SESSION["medical_logged_in"] = true;

        $_SESSION["medical_user"] = $username;

        $_SESSION["login_time"] =
            date("d-m-Y h:i:s A");


        header(
            "Location: process.php?page=records"
        );

        exit();

    }


    header(
        "Location: index.php?message=Invalid login. Access denied.&type=error"
    );

    exit();

}



// --------------------------------------------------
// MEDICAL RECORDS
// --------------------------------------------------

if (
    isset($_GET["page"]) &&
    $_GET["page"] === "records"
) {


    // Check authentication

    if (
        !isset($_SESSION["medical_logged_in"]) ||
        $_SESSION["medical_logged_in"] !== true
    ) {

        header(
            "Location: index.php?message=Unauthorized access. Please login first.&type=error"
        );

        exit();

    }


    $records = [];


    // Read medical records securely

    if (
        file_exists($recordFile) &&
        is_readable($recordFile)
    ) {

        $lines =
            file(
                $recordFile,
                FILE_IGNORE_NEW_LINES |
                FILE_SKIP_EMPTY_LINES
            );


        foreach ($lines as $line) {

            $data =
                explode("|", $line);


            if (count($data) === 5) {

                $records[] = $data;

            }

        }

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
            Medical Records
        </title>

        <link rel="stylesheet" href="style.css">

    </head>

    <body>

    <div class="container">

        <header class="records-header">

            <div class="icon">
                🩺
            </div>

            <h1>
                Medical Records
            </h1>

            <p>
                Authorized medical staff area
            </p>

        </header>


        <main>

            <section class="staff-bar">

                <div>

                    <span>
                        Logged-in Staff
                    </span>

                    <strong>
                        <?= htmlspecialchars(
                            $_SESSION["medical_user"]
                        ) ?>
                    </strong>

                </div>


                <div>

                    <span>
                        Login Time
                    </span>

                    <strong>
                        <?= htmlspecialchars(
                            $_SESSION["login_time"]
                        ) ?>
                    </strong>

                </div>


                <div>

                    <span>
                        Access Status
                    </span>

                    <strong class="authorized">
                        ✓ Authorized
                    </strong>

                </div>

            </section>


            <section class="warning">

                <span>
                    ⚠️
                </span>

                <div>

                    <strong>
                        Confidential Information
                    </strong>

                    <p>
                        These medical records contain sensitive information.
                        Access is restricted to authorized medical staff.
                    </p>

                </div>

            </section>


            <section class="records-card">

                <div class="section-title">

                    <div>

                        <h2>
                            📋 Patient Medical Records
                        </h2>

                        <p>
                            Securely retrieved from the medical records file.
                        </p>

                    </div>

                    <span class="record-count">

                        <?= count($records) ?>

                        Records

                    </span>

                </div>


                <?php if (count($records) > 0): ?>

                    <div class="table-container">

                        <table>

                            <thead>

                                <tr>

                                    <th>
                                        Record ID
                                    </th>

                                    <th>
                                        Patient Name
                                    </th>

                                    <th>
                                        Age
                                    </th>

                                    <th>
                                        Department
                                    </th>

                                    <th>
                                        Medical Report
                                    </th>

                                </tr>

                            </thead>


                            <tbody>

                                <?php foreach ($records as $record): ?>

                                    <tr>

                                        <td>

                                            <?= htmlspecialchars(
                                                $record[0]
                                            ) ?>

                                        </td>


                                        <td>

                                            <?= htmlspecialchars(
                                                $record[1]
                                            ) ?>

                                        </td>


                                        <td>

                                            <?= htmlspecialchars(
                                                $record[2]
                                            ) ?>

                                        </td>


                                        <td>

                                            <?= htmlspecialchars(
                                                $record[3]
                                            ) ?>

                                        </td>


                                        <td>

                                            <?= htmlspecialchars(
                                                $record[4]
                                            ) ?>

                                        </td>

                                    </tr>

                                <?php endforeach; ?>

                            </tbody>

                        </table>

                    </div>

                <?php else: ?>

                    <div class="no-records">

                        No medical records available.

                    </div>

                <?php endif; ?>

            </section>


            <section class="security-note">

                <h2>
                    🔒 Record Security
                </h2>

                <p>

                    The medical records are protected using
                    session-based authentication. The file is checked
                    before reading, and record contents are escaped
                    before displaying them on the webpage.

                </p>

            </section>


            <a
                href="process.php?action=logout"
                class="logout"
            >

                🔒 Logout Securely

            </a>

        </main>


        <footer>

            Secure Medical Record Management System

        </footer>

    </div>

    </body>

    </html>

    <?php

    exit();

}



// --------------------------------------------------
// LOGOUT
// --------------------------------------------------

if (
    isset($_GET["action"]) &&
    $_GET["action"] === "logout"
) {


    // Remove session data

    $_SESSION = [];


    // Destroy session

    session_destroy();


    header(
        "Location: index.php?message=Logged out successfully.&type=success"
    );

    exit();

}



// Invalid request

header(
    "Location: index.php?message=Invalid request.&type=error"
);

exit();

?>