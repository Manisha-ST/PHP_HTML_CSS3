<?php

session_start();

// Demo employee credentials
$validUsername = "employee01";
$validPassword = "employee123";

// Check whether the form was submitted
if ($_SERVER["REQUEST_METHOD"] !== "POST") {

    header("Location: index.php");
    exit();

}

// Get entered values
$username = trim($_POST["username"] ?? "");
$password = trim($_POST["password"] ?? "");

// Check empty fields
if ($username === "" || $password === "") {

    $errorMessage = "Please enter both username and password.";

} elseif (
    $username === $validUsername &&
    $password === $validPassword
) {

    // Store employee information in session
    $_SESSION["employee_logged_in"] = true;
    $_SESSION["employee_username"] = $username;

} else {

    $errorMessage = "Invalid username or password.";

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

    <title>Employee Login Result</title>

    <link rel="stylesheet" href="style.css">

</head>

<body>

    <div class="page-container">

        <?php if (isset($errorMessage)): ?>

            <div class="result-card error-card">

                <div class="result-icon">
                    ❌
                </div>

                <h1>Login Failed</h1>

                <p class="message">
                    <?= htmlspecialchars($errorMessage) ?>
                </p>

                <a href="index.php" class="back-button">
                    Try Again
                </a>

            </div>

        <?php else: ?>

            <div class="result-card success-card">

                <div class="result-icon">
                    ✓
                </div>

                <h1>Login Successful</h1>

                <p class="message">
                    Welcome,
                    <strong>
                        <?= htmlspecialchars($_SESSION["employee_username"]) ?>
                    </strong>
                </p>

                <div class="employee-details">

                    <div class="detail">

                        <span>
                            Employee Username
                        </span>

                        <strong>
                            <?= htmlspecialchars($_SESSION["employee_username"]) ?>
                        </strong>

                    </div>

                    <div class="detail">

                        <span>
                            Login Status
                        </span>

                        <strong>
                            Active
                        </strong>

                    </div>

                    <div class="detail">

                        <span>
                            Session Status
                        </span>

                        <strong>
                            Started
                        </strong>

                    </div>

                </div>

                <a href="index.php" class="back-button">
                    Logout / Back to Login
                </a>

            </div>

        <?php endif; ?>

    </div>

</body>

</html>