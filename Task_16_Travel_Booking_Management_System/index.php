<?php

session_start();

$message = $_SESSION["message"] ?? "";
$messageType = $_SESSION["message_type"] ?? "";

unset($_SESSION["message"]);
unset($_SESSION["message_type"]);

$bookingsFile = "bookings.txt";

$bookings = [];

if (file_exists($bookingsFile)) {

    $bookings = file(
        $bookingsFile,
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

    <title>Travel Booking System</title>

    <link rel="stylesheet" href="style.css">

</head>

<body>

<div class="page">

    <header>

        <div class="travel-icon">
            ✈️
        </div>

        <h1>
            Travel Booking
        </h1>

        <p>
            Plan your journey and confirm your booking
        </p>

    </header>


    <main>

        <?php if ($message != ""): ?>

            <div class="message <?= $messageType ?>">

                <?= htmlspecialchars($message) ?>

            </div>

        <?php endif; ?>


        <section class="booking-card">

            <div class="section-heading">

                <span class="heading-icon">
                    🌍
                </span>

                <div>

                    <h2>
                        Book Your Journey
                    </h2>

                    <p>
                        Enter customer and travel details
                    </p>

                </div>

            </div>


            <form
                action="process.php"
                method="POST"
            >

                <div class="form-grid">


                    <div class="form-group">

                        <label for="name">
                            Customer Name
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
                            placeholder="Enter your email"
                            required
                        >

                    </div>


                    <div class="form-group">

                        <label for="destination">
                            Destination
                        </label>

                        <select
                            id="destination"
                            name="destination"
                            required
                        >

                            <option value="">
                                Select destination
                            </option>

                            <option value="Chennai">
                                Chennai
                            </option>

                            <option value="Bangalore">
                                Bangalore
                            </option>

                            <option value="Kochi">
                                Kochi
                            </option>

                            <option value="Hyderabad">
                                Hyderabad
                            </option>

                            <option value="Mysore">
                                Mysore
                            </option>

                        </select>

                    </div>


                    <div class="form-group">

                        <label for="travel_date">
                            Travel Date
                        </label>

                        <input
                            type="date"
                            id="travel_date"
                            name="travel_date"
                            min="<?= date('Y-m-d') ?>"
                            required
                        >

                    </div>


                    <div class="form-group">

                        <label for="return_date">
                            Return Date
                        </label>

                        <input
                            type="date"
                            id="return_date"
                            name="return_date"
                            min="<?= date('Y-m-d') ?>"
                            required
                        >

                    </div>


                    <div class="form-group">

                        <label for="travelers">
                            Number of Travelers
                        </label>

                        <input
                            type="number"
                            id="travelers"
                            name="travelers"
                            min="1"
                            max="10"
                            value="1"
                            required
                        >

                    </div>

                </div>


                <button type="submit">

                    Confirm Travel Booking

                </button>

            </form>

        </section>


        <section class="schedule">

            <div class="schedule-header">

                <div>

                    <h2>
                        🗓️ Booking Schedule
                    </h2>

                    <p>
                        Current travel bookings
                    </p>

                </div>

                <span class="booking-count">
                    <?= count($bookings) ?> Bookings
                </span>

            </div>


            <?php if (empty($bookings)): ?>

                <div class="empty">

                    <div class="empty-icon">
                        🧳
                    </div>

                    <h3>
                        No bookings yet
                    </h3>

                    <p>
                        Your confirmed bookings will appear here.
                    </p>

                </div>

            <?php else: ?>

                <div class="booking-list">

                    <?php foreach ($bookings as $booking): ?>

                        <?php

                        $data = explode("|", $booking);

                        ?>

                        <div class="booking-item">

                            <div class="destination-box">

                                <span>
                                    DESTINATION
                                </span>

                                <strong>
                                    <?= htmlspecialchars($data[2] ?? "") ?>
                                </strong>

                            </div>


                            <div class="booking-info">

                                <h3>

                                    <?= htmlspecialchars($data[0] ?? "") ?>

                                </h3>

                                <p>

                                    ✉
                                    <?= htmlspecialchars($data[1] ?? "") ?>

                                </p>

                                <p>

                                    📅
                                    <?= htmlspecialchars($data[3] ?? "") ?>

                                    →
                                    <?= htmlspecialchars($data[4] ?? "") ?>

                                </p>

                                <p>

                                    👥
                                    <?= htmlspecialchars($data[5] ?? "") ?>
                                    Traveler(s)

                                </p>

                            </div>

                        </div>

                    <?php endforeach; ?>

                </div>

            <?php endif; ?>

        </section>


        <div class="session-info">

            <span>
                🔒
            </span>

            <p>
                Customer booking information is maintained
                using PHP sessions and file handling.
            </p>

        </div>

    </main>


    <footer>

        Travel Booking Management System

    </footer>

</div>

</body>

</html>