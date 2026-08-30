<?php

session_start();


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


    // Validate input

    if (
        $username === "" ||
        $password === ""
    ) {

        header(
            "Location: index.php?message=Please enter username and password.&type=error"
        );

        exit();

    }


    // Demo credentials

    $validUsername = "student";

    $validPassword = "exam123";


    // Authenticate user

    if (
        $username === $validUsername &&
        $password === $validPassword
    ) {


        // Regenerate session ID

        session_regenerate_id(true);


        // Store authentication information

        $_SESSION["exam_authenticated"] = true;

        $_SESSION["username"] = $username;

        $_SESSION["exam_start"] =
            date("d-m-Y h:i:s A");


        // Create secure cookie

        setcookie(
            "exam_user",
            $username,
            [
                "expires" => time() + 3600,
                "path" => "/",
                "httponly" => true,
                "samesite" => "Lax"
            ]
        );


        // HTTP header access control

        header(
            "Location: process.php?page=exam"
        );

        exit();

    }


    // Invalid credentials

    header(
        "Location: index.php?message=Invalid credentials. Examination access denied.&type=error"
    );

    exit();

}



// --------------------------------------------------
// EXAMINATION PAGE
// --------------------------------------------------

if (
    isset($_GET["page"]) &&
    $_GET["page"] === "exam"
) {


    // Check session authentication

    if (
        !isset($_SESSION["exam_authenticated"]) ||
        $_SESSION["exam_authenticated"] !== true
    ) {

        header(
            "Location: index.php?message=Unauthorized access. Please login first.&type=error"
        );

        exit();

    }


    $username =
        $_SESSION["username"];


    $examStart =
        $_SESSION["exam_start"];

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
            Examination
        </title>

        <link rel="stylesheet" href="style.css">

    </head>

    <body>

    <div class="container">

        <header class="exam-header">

            <div class="icon">
                📝
            </div>

            <h1>
                Online Examination
            </h1>

            <p>
                Secure examination environment
            </p>

        </header>


        <main>

            <section class="student-bar">

                <div>

                    <span>
                        Student
                    </span>

                    <strong>
                        <?= htmlspecialchars($username) ?>
                    </strong>

                </div>


                <div>

                    <span>
                        Status
                    </span>

                    <strong class="authorized">
                        ✓ Authorized
                    </strong>

                </div>


                <div>

                    <span>
                        Login Time
                    </span>

                    <strong>
                        <?= htmlspecialchars($examStart) ?>
                    </strong>

                </div>

            </section>


            <section class="exam-card">

                <div class="exam-title">

                    <div class="question-number">
                        01
                    </div>

                    <div>

                        <h2>
                            PHP and Web Development
                        </h2>

                        <p>
                            Answer the following questions.
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
                        value="submit_exam"
                    >


                    <div class="question">

                        <h3>
                            1. Which PHP function is used to start a session?
                        </h3>

                        <label>

                            <input
                                type="radio"
                                name="q1"
                                value="session_start"
                                required
                            >

                            session_start()

                        </label>


                        <label>

                            <input
                                type="radio"
                                name="q1"
                                value="start_session"
                            >

                            start_session()

                        </label>


                        <label>

                            <input
                                type="radio"
                                name="q1"
                                value="session_begin"
                            >

                            session_begin()

                        </label>

                    </div>


                    <div class="question">

                        <h3>
                            2. Which method is commonly used for secure form submission?
                        </h3>

                        <label>

                            <input
                                type="radio"
                                name="q2"
                                value="POST"
                                required
                            >

                            POST

                        </label>


                        <label>

                            <input
                                type="radio"
                                name="q2"
                                value="GET"
                            >

                            GET

                        </label>


                        <label>

                            <input
                                type="radio"
                                name="q2"
                                value="LINK"
                            >

                            LINK

                        </label>

                    </div>


                    <div class="question">

                        <h3>
                            3. Which PHP function is used to redirect a user?
                        </h3>

                        <label>

                            <input
                                type="radio"
                                name="q3"
                                value="header"
                                required
                            >

                            header()

                        </label>


                        <label>

                            <input
                                type="radio"
                                name="q3"
                                value="redirect"
                            >

                            redirect()

                        </label>


                        <label>

                            <input
                                type="radio"
                                name="q3"
                                value="move"
                            >

                            move()

                        </label>

                    </div>


                    <button
                        type="submit"
                        class="submit-button"
                    >

                        ✓ Submit Examination

                    </button>

                </form>

            </section>


            <section class="access-info">

                <h2>
                    🔒 Protected Examination Area
                </h2>

                <p>
                    Your examination page is protected using
                    PHP sessions and HTTP header-based access control.
                    Only authenticated students can access this page.
                </p>

            </section>


            <a
                href="process.php?action=logout"
                class="logout"
            >

                Logout Securely

            </a>

        </main>


        <footer>

            Secure Examination Access Control System

        </footer>

    </div>

    </body>

    </html>

    <?php

    exit();

}



// --------------------------------------------------
// SUBMIT EXAM
// --------------------------------------------------

if (
    $_SERVER["REQUEST_METHOD"] === "POST" &&
    ($_POST["action"] ?? "") === "submit_exam"
) {


    // Check authentication

    if (
        !isset($_SESSION["exam_authenticated"]) ||
        $_SESSION["exam_authenticated"] !== true
    ) {

        header(
            "Location: index.php?message=Unauthorized access.&type=error"
        );

        exit();

    }


    $score = 0;


    // Correct answers

    if (
        ($_POST["q1"] ?? "") === "session_start"
    ) {

        $score++;

    }


    if (
        ($_POST["q2"] ?? "") === "POST"
    ) {

        $score++;

    }


    if (
        ($_POST["q3"] ?? "") === "header"
    ) {

        $score++;

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
            Examination Result
        </title>

        <link rel="stylesheet" href="style.css">

    </head>

    <body>

    <div class="container">

        <header>

            <div class="icon">
                🏆
            </div>

            <h1>
                Examination Completed
            </h1>

            <p>
                Your examination has been submitted successfully.
            </p>

        </header>


        <main>

            <section class="result-card">

                <div class="result-icon">
                    ✓
                </div>

                <h2>
                    Examination Submitted!
                </h2>

                <p>
                    Student:
                    <strong>
                        <?= htmlspecialchars(
                            $_SESSION["username"]
                        ) ?>
                    </strong>
                </p>


                <div class="score">

                    <span>
                        Your Score
                    </span>

                    <strong>

                        <?= $score ?>

                        / 3

                    </strong>

                </div>


                <a
                    href="process.php?action=logout"
                    class="logout"
                >

                    Logout

                </a>

            </section>

        </main>


        <footer>

            Secure Examination Access Control System

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


    // Remove session information

    $_SESSION = [];


    // Delete cookie

    setcookie(
        "exam_user",
        "",
        [
            "expires" => time() - 3600,
            "path" => "/",
            "httponly" => true,
            "samesite" => "Lax"
        ]
    );


    session_destroy();


    // Redirect using HTTP header

    header(
        "Location: index.php?message=You have been logged out securely.&type=success"
    );

    exit();

}



// Invalid request

header(
    "Location: index.php?message=Invalid request.&type=error"
);

exit();

?>