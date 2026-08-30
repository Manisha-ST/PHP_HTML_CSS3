<?php

session_start();

// Check whether the form was submitted
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: index.php");
    exit();
}

// Get form values
$name = trim($_POST["name"] ?? "");
$registerNumber = trim($_POST["register_number"] ?? "");
$email = trim($_POST["email"] ?? "");
$course = trim($_POST["course"] ?? "");
$year = trim($_POST["year"] ?? "");

// Validate the input fields
if (
    $name === "" ||
    $registerNumber === "" ||
    $email === "" ||
    $course === "" ||
    $year === ""
) {
    die("Error: All fields are required.");
}

// Validate email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die("Error: Please enter a valid email address.");
}

// Store student details in session
$_SESSION["student"] = [
    "name" => $name,
    "register_number" => $registerNumber,
    "email" => $email,
    "course" => $course,
    "year" => $year
];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Registration Successful</title>

    <link rel="stylesheet" href="style.css">
</head>

<body>

    <div class="container">

        <header>
            <h1>Registration Successful</h1>
            <p>Student information has been stored</p>
        </header>

        <main class="result-card">

            <div class="success-message">
                Student registration completed successfully!
            </div>

            <h2>Student Details</h2>

            <div class="details">

                <div class="detail-row">
                    <span>Student Name</span>
                    <strong>
                        <?= htmlspecialchars($_SESSION["student"]["name"]) ?>
                    </strong>
                </div>

                <div class="detail-row">
                    <span>Register Number</span>
                    <strong>
                        <?= htmlspecialchars($_SESSION["student"]["register_number"]) ?>
                    </strong>
                </div>

                <div class="detail-row">
                    <span>Email</span>
                    <strong>
                        <?= htmlspecialchars($_SESSION["student"]["email"]) ?>
                    </strong>
                </div>

                <div class="detail-row">
                    <span>Course</span>
                    <strong>
                        <?= htmlspecialchars($_SESSION["student"]["course"]) ?>
                    </strong>
                </div>

                <div class="detail-row">
                    <span>Year</span>
                    <strong>
                        <?= htmlspecialchars($_SESSION["student"]["year"]) ?>
                    </strong>
                </div>

            </div>

            <a href="index.php" class="back-button">
                Register Another Student
            </a>

        </main>

    </div>

</body>

</html>