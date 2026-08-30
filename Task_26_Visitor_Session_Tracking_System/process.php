<?php

session_start();


// Initialize session

if (!isset($_SESSION["visitor"])) {

    $_SESSION["visitor"] = "Visitor";

}


if (!isset($_SESSION["visit_count"])) {

    $_SESSION["visit_count"] = 0;

}


if (!isset($_SESSION["visited_pages"])) {

    $_SESSION["visited_pages"] = [];

}


// --------------------------------------------------
// RESET SESSION
// --------------------------------------------------

if (
    isset($_GET["action"]) &&
    $_GET["action"] === "reset"
) {

    session_unset();

    session_destroy();

    session_start();

    $_SESSION["visitor"] = "Visitor";

    $_SESSION["visit_count"] = 0;

    $_SESSION["visited_pages"] = [];


    header(
        "Location: index.php"
    );

    exit();

}


// --------------------------------------------------
// PAGE VISIT TRACKING
// --------------------------------------------------

$page = $_GET["page"] ?? "";


// Page names

$pageNames = [

    "about" => "About Us",

    "services" => "Services",

    "contact" => "Contact"

];


// Check valid page

if (!array_key_exists(
    $page,
    $pageNames
)) {

    header(
        "Location: index.php"
    );

    exit();

}


$currentPage =
    $pageNames[$page];


// Increase visit count

$_SESSION["visit_count"]++;


// Add page to session history

$_SESSION["visited_pages"][] = [

    "page" => $currentPage,

    "time" => date("d-m-Y h:i:s A")

];

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

        <?= htmlspecialchars($currentPage) ?>

    </title>

    <link rel="stylesheet" href="style.css">

</head>

<body>

<div class="container">

    <header>

        <div class="icon">

            <?php

            if ($page === "about") {

                echo "📖";

            } elseif ($page === "services") {

                echo "🛠";

            } else {

                echo "📞";

            }

            ?>

        </div>

        <h1>

            <?= htmlspecialchars($currentPage) ?>

        </h1>

        <p>
            This page visit has been recorded
        </p>

    </header>


    <main>

        <section class="page-card">

            <div class="success-icon">
                ✓
            </div>

            <h2>
                Page Visit Recorded
            </h2>

            <p>

                You are currently viewing:

                <strong>
                    <?= htmlspecialchars($currentPage) ?>
                </strong>

            </p>


            <div class="visit-count">

                <span>
                    Pages visited in this session
                </span>

                <strong>
                    <?= $_SESSION["visit_count"] ?>
                </strong>

            </div>


            <a
                href="index.php"
                class="home-button"
            >

                ← Back to Home

            </a>

        </section>


        <!-- PAGE CONTENT -->

        <section class="content-card">

            <?php if ($page === "about"): ?>

                <h2>
                    📖 About Us
                </h2>

                <p>
                    Welcome to our website.
                    This page demonstrates how PHP sessions
                    can track the pages visited by a user.
                </p>

                <p>
                    Every time you visit a page, the page name
                    and visit time are stored in the session.
                </p>


            <?php elseif ($page === "services"): ?>

                <h2>
                    🛠 Our Services
                </h2>

                <div class="service-list">

                    <div>
                        💻 Web Development
                    </div>

                    <div>
                        🎨 Web Designing
                    </div>

                    <div>
                        📊 Data Management
                    </div>

                    <div>
                        🔐 Secure Applications
                    </div>

                </div>


            <?php else: ?>

                <h2>
                    📞 Contact Us
                </h2>

                <p>
                    Email:
                    example@gmail.com
                </p>

                <p>
                    Phone:
                    +91 98765 43210
                </p>

                <p>
                    Location:
                    Coimbatore, Tamil Nadu
                </p>

            <?php endif; ?>

        </section>


        <!-- SESSION SUMMARY -->

        <section class="summary">

            <h2>
                📊 Current Session Summary
            </h2>

            <div class="summary-grid">

                <div>

                    <span>
                        Visitor
                    </span>

                    <strong>
                        <?= htmlspecialchars(
                            $_SESSION["visitor"]
                        ) ?>
                    </strong>

                </div>


                <div>

                    <span>
                        Pages Visited
                    </span>

                    <strong>
                        <?= $_SESSION["visit_count"] ?>
                    </strong>

                </div>


                <div>

                    <span>
                        Session Status
                    </span>

                    <strong class="active">
                        Active
                    </strong>

                </div>

            </div>

        </section>

    </main>


    <footer>

        Visitor Session Tracking System

    </footer>

</div>

</body>

</html>