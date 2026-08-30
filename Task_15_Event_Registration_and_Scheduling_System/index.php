<?php

session_start();

$eventsFile = "events.txt";

$events = [];

if (file_exists($eventsFile)) {

    $events = file(
        $eventsFile,
        FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES
    );

}


$message = $_SESSION["message"] ?? "";

$messageType = $_SESSION["message_type"] ?? "";

unset($_SESSION["message"]);
unset($_SESSION["message_type"]);

?>

<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Event Registration</title>

    <link rel="stylesheet" href="style.css">

</head>

<body>

<div class="container">

    <header>

        <div class="calendar-icon">
            🎟️
        </div>

        <h1>
            Event Registration
        </h1>

        <p>
            Register for upcoming events and manage schedules
        </p>

    </header>


    <main>


        <?php if ($message != ""): ?>

            <div class="message <?= $messageType ?>">

                <?= htmlspecialchars($message) ?>

            </div>

        <?php endif; ?>


        <section class="registration-card">

            <div class="title">

                <span>
                    ✦
                </span>

                <div>

                    <h2>
                        Register for an Event
                    </h2>

                    <p>
                        Enter your details and select an event date.
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
                    value="register"
                >


                <div class="form-grid">


                    <div class="form-group">

                        <label for="name">
                            Participant Name
                        </label>

                        <input
                            type="text"
                            id="name"
                            name="name"
                            placeholder="Enter your name"
                            required
                        >

                    </div>


                    <div class="form-group">

                        <label for="email">
                            Email Address
                        </label>

                        <input
                            type="email"
                            id="email"
                            name="email"
                            placeholder="Enter email address"
                            required
                        >

                    </div>


                    <div class="form-group">

                        <label for="event">
                            Select Event
                        </label>

                        <select
                            id="event"
                            name="event"
                            required
                        >

                            <option value="">
                                Choose an event
                            </option>

                            <option value="Web Design Workshop">
                                Web Design Workshop
                            </option>

                            <option value="Coding Seminar">
                                Coding Seminar
                            </option>

                            <option value="Career Guidance">
                                Career Guidance
                            </option>

                            <option value="Tech Exhibition">
                                Tech Exhibition
                            </option>

                        </select>

                    </div>


                    <div class="form-group">

                        <label for="event_date">
                            Event Date
                        </label>

                        <input
                            type="date"
                            id="event_date"
                            name="event_date"
                            min="<?= date('Y-m-d') ?>"
                            required
                        >

                    </div>


                    <div class="form-group">

                        <label for="event_time">
                            Event Time
                        </label>

                        <input
                            type="time"
                            id="event_time"
                            name="event_time"
                            required
                        >

                    </div>


                    <div class="form-group">

                        <label for="participants">
                            Number of Participants
                        </label>

                        <input
                            type="number"
                            id="participants"
                            name="participants"
                            min="1"
                            max="10"
                            value="1"
                            required
                        >

                    </div>

                </div>


                <button type="submit">

                    Register for Event →

                </button>

            </form>

        </section>


        <section class="schedule">

            <div class="schedule-title">

                <div>

                    <h2>
                        📅 Event Schedule
                    </h2>

                    <p>
                        Registered events are displayed below.
                    </p>

                </div>

                <span class="count">
                    <?= count($events) ?> Events
                </span>

            </div>


            <?php if (empty($events)): ?>

                <div class="empty">

                    <div>
                        📭
                    </div>

                    <h3>
                        No registrations yet
                    </h3>

                    <p>
                        Register for an event using the form above.
                    </p>

                </div>

            <?php else: ?>

                <div class="event-list">

                    <?php foreach ($events as $event): ?>

                        <?php

                        $data = explode("|", $event);

                        ?>

                        <div class="event-card">

                            <div class="event-date">

                                <span>
                                    DATE
                                </span>

                                <strong>
                                    <?= htmlspecialchars($data[3] ?? "") ?>
                                </strong>

                            </div>


                            <div class="event-details">

                                <h3>
                                    <?= htmlspecialchars($data[1] ?? "") ?>
                                </h3>

                                <p>
                                    👤
                                    <?= htmlspecialchars($data[0] ?? "") ?>
                                </p>

                                <p>
                                    ✉
                                    <?= htmlspecialchars($data[2] ?? "") ?>
                                </p>

                                <p>
                                    ⏰
                                    <?= htmlspecialchars($data[4] ?? "") ?>
                                </p>

                            </div>

                        </div>

                    <?php endforeach; ?>

                </div>

            <?php endif; ?>

        </section>


        <div class="session-note">

            <span>
                🔐
            </span>

            <p>
                Registration information is maintained using
                PHP sessions and event details are stored
                using file handling.
            </p>

        </div>

    </main>


    <footer>

        Event Registration & Scheduling System

    </footer>

</div>

</body>

</html>