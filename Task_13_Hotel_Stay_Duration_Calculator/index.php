<?php

$checkIn = "";
$checkOut = "";
$result = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $checkIn = $_POST["check_in"] ?? "";
    $checkOut = $_POST["check_out"] ?? "";

    if ($checkIn == "" || $checkOut == "") {

        $error = "Please enter both check-in and check-out dates.";

    } else {

        $startDate = new DateTime($checkIn);
        $endDate = new DateTime($checkOut);

        if ($endDate <= $startDate) {

            $error = "Check-out date must be after check-in date.";

        } else {

            $difference = $startDate->diff($endDate);

            $days = $difference->days;

            $result = "Guest stayed for " . $days . " day(s).";
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

    <title>Hotel Stay Calculator</title>

    <link rel="stylesheet" href="style.css">

</head>

<body>

<div class="container">

    <div class="hotel-card">

        <div class="header">

            <div class="hotel-icon">
                🏨
            </div>

            <h1>
                Hotel Stay Calculator
            </h1>

            <p>
                Calculate your total duration of stay
            </p>

        </div>


        <div class="content">

            <form
                method="POST"
                action=""
            >

                <div class="form-group">

                    <label for="check_in">
                        Check-in Date
                    </label>

                    <input
                        type="date"
                        id="check_in"
                        name="check_in"
                        value="<?= htmlspecialchars($checkIn) ?>"
                        required
                    >

                </div>


                <div class="form-group">

                    <label for="check_out">
                        Check-out Date
                    </label>

                    <input
                        type="date"
                        id="check_out"
                        name="check_out"
                        value="<?= htmlspecialchars($checkOut) ?>"
                        required
                    >

                </div>


                <button type="submit">
                    Calculate Stay
                </button>

            </form>


            <?php if ($result != ""): ?>

                <div class="result">

                    <div class="result-icon">
                        ✓
                    </div>

                    <h2>
                        Stay Duration
                    </h2>

                    <p>
                        <?= htmlspecialchars($result) ?>
                    </p>

                    <div class="dates">

                        <div>

                            <span>
                                CHECK-IN
                            </span>

                            <strong>
                                <?= htmlspecialchars($checkIn) ?>
                            </strong>

                        </div>


                        <div class="arrow">
                            →
                        </div>


                        <div>

                            <span>
                                CHECK-OUT
                            </span>

                            <strong>
                                <?= htmlspecialchars($checkOut) ?>
                            </strong>

                        </div>

                    </div>

                </div>

            <?php endif; ?>


            <?php if ($error != ""): ?>

                <div class="error">

                    ⚠

                    <?= htmlspecialchars($error) ?>

                </div>

            <?php endif; ?>

        </div>


        <div class="footer">

            Hotel Reservation Services

        </div>

    </div>

</div>

</body>

</html>