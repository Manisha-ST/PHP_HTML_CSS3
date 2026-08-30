<?php

date_default_timezone_set("Asia/Kolkata");

$currentDate = date("d-m-Y");
$currentTime = date("h:i:s A");

$fullDate = date("l, F d, Y");

$shortDate = date("d/m/Y");

$time24 = date("H:i:s");

$day = date("l");

$month = date("F");

$year = date("Y");

?>

<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Date and Time Report</title>

    <link rel="stylesheet" href="style.css">

</head>

<body>

<div class="page">

    <div class="header">

        <div class="clock">
            🕐
        </div>

        <h1>
            Date & Time Report
        </h1>

        <p>
            Current Date and Time Information
        </p>

    </div>


    <div class="content">

        <div class="main-date">

            <span>
                TODAY
            </span>

            <h2>
                <?= $fullDate ?>
            </h2>

            <div class="time">
                <?= $currentTime ?>
            </div>

        </div>


        <div class="report-grid">


            <div class="report-card">

                <div class="icon">
                    📅
                </div>

                <h3>
                    Standard Date
                </h3>

                <p>
                    <?= $currentDate ?>
                </p>

            </div>


            <div class="report-card">

                <div class="icon">
                    📆
                </div>

                <h3>
                    Short Date
                </h3>

                <p>
                    <?= $shortDate ?>
                </p>

            </div>


            <div class="report-card">

                <div class="icon">
                    ⏰
                </div>

                <h3>
                    24-Hour Time
                </h3>

                <p>
                    <?= $time24 ?>
                </p>

            </div>


            <div class="report-card">

                <div class="icon">
                    🗓️
                </div>

                <h3>
                    Day
                </h3>

                <p>
                    <?= $day ?>
                </p>

            </div>


            <div class="report-card">

                <div class="icon">
                    🌙
                </div>

                <h3>
                    Month
                </h3>

                <p>
                    <?= $month ?>
                </p>

            </div>


            <div class="report-card">

                <div class="icon">
                    🔢
                </div>

                <h3>
                    Year
                </h3>

                <p>
                    <?= $year ?>
                </p>

            </div>

        </div>


        <div class="info">

            <strong>
                📍 Time Zone:
            </strong>

            Asia/Kolkata (Indian Standard Time)

        </div>

    </div>


    <div class="footer">

        Date and Time Report Generator

    </div>

</div>

</body>

</html>