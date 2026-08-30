<?php

session_start();


// Create session variables

if (!isset($_SESSION["visitor"])) {

    $_SESSION["visitor"] = "Visitor";

}


if (!isset($_SESSION["visit_count"])) {

    $_SESSION["visit_count"] = 0;

}


if (!isset($_SESSION["visited_pages"])) {

    $_SESSION["visited_pages"] = [];

}


// Current page

$currentPage = "Home Page";


// Count page visit

$_SESSION["visit_count"]++;


// Store visited page

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
        Visitor Session Tracking
    </title>

    <link rel="stylesheet" href="style.css">

</head>

<body>

<div class="container">

    <header>

        <div class="icon">
            👣
        </div>

        <h1>
            Visitor Session Tracking
        </h1>

        <p>
            Track your browsing activity using PHP sessions
        </p>

    </header>


    <main>

        <!-- VISITOR INFO -->

        <section class="visitor-card">

            <div class="visitor-icon">
                👤
            </div>

            <div>

                <h2>
                    Welcome, <?= htmlspecialchars($_SESSION["visitor"]) ?>!
                </h2>

                <p>
                    Your current browsing session is being tracked.
                </p>

            </div>

        </section>


        <!-- STATISTICS -->

        <section class="stats">

            <div class="stat-card">

                <div class="stat-icon">
                    🔢
                </div>

                <h3>
                    Pages Visited
                </h3>

                <strong>
                    <?= $_SESSION["visit_count"] ?>
                </strong>

            </div>


            <div class="stat-card">

                <div class="stat-icon">
                    🕐
                </div>

                <h3>
                    Current Time
                </h3>

                <strong class="time">

                    <?= date("h:i:s A") ?>

                </strong>

            </div>


            <div class="stat-card">

                <div class="stat-icon">
                    🔐
                </div>

                <h3>
                    Session Status
                </h3>

                <strong class="active">
                    Active
                </strong>

            </div>

        </section>


        <!-- NAVIGATION -->

        <section class="navigation">

            <h2>
                🌐 Browse Pages
            </h2>

            <p>
                Click the buttons below to simulate visiting different pages.
                Each visit is recorded in the current session.
            </p>


            <div class="nav-buttons">

                <a
                    href="process.php?page=about"
                >
                    📖 About Us
                </a>


                <a
                    href="process.php?page=services"
                >
                    🛠 Services
                </a>


                <a
                    href="process.php?page=contact"
                >
                    📞 Contact
                </a>

            </div>

        </section>


        <!-- VISIT HISTORY -->

        <section class="history">

            <div class="section-heading">

                <div>

                    <h2>
                        📋 Browsing History
                    </h2>

                    <p>
                        Pages visited during this session.
                    </p>

                </div>

                <span class="count">

                    <?= count($_SESSION["visited_pages"]) ?>

                    Visits

                </span>

            </div>


            <div class="history-list">

                <?php

                $history =
                    array_reverse(
                        $_SESSION["visited_pages"]
                    );

                ?>

                <?php foreach ($history as $index => $visit): ?>

                    <div class="history-item">

                        <div class="number">

                            <?= count($history) - $index ?>

                        </div>

                        <div class="page-info">

                            <strong>
                                <?= htmlspecialchars($visit["page"]) ?>
                            </strong>

                            <span>
                                Visited at
                                <?= htmlspecialchars($visit["time"]) ?>
                            </span>

                        </div>

                    </div>

                <?php endforeach; ?>

            </div>

        </section>


        <!-- SESSION INFORMATION -->

        <section class="session-info">

            <h2>
                🔒 Session Information
            </h2>

            <div class="info-grid">

                <div>

                    <span>
                        Session ID
                    </span>

                    <strong>

                        <?= htmlspecialchars(
                            session_id()
                        ) ?>

                    </strong>

                </div>


                <div>

                    <span>
                        Total Page Visits
                    </span>

                    <strong>

                        <?= $_SESSION["visit_count"] ?>

                    </strong>

                </div>


                <div>

                    <span>
                        Tracking Method
                    </span>

                    <strong>
                        PHP Session
                    </strong>

                </div>

            </div>

        </section>


        <!-- RESET -->

        <section class="reset">

            <a
                href="process.php?action=reset"
                onclick="return confirm('Start a new browsing session?');"
            >

                🔄 Start New Session

            </a>

        </section>

    </main>


    <footer>

        Visitor Session Tracking System

    </footer>

</div>

</body>

</html>