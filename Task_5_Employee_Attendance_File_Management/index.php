<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Employee Login</title>

    <link rel="stylesheet" href="style.css">
</head>

<body>

    <div class="page-container">

        <div class="login-card">

            <div class="login-header">
                <div class="icon">
                    👤
                </div>

                <h1>Employee Login</h1>

                <p>Login to access your employee account</p>
            </div>

            <form action="process.php" method="POST">

                <div class="form-group">

                    <label for="username">
                        Employee Username
                    </label>

                    <input
                        type="text"
                        id="username"
                        name="username"
                        placeholder="Enter username"
                        required
                    >

                </div>

                <div class="form-group">

                    <label for="password">
                        Password
                    </label>

                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Enter password"
                        required
                    >

                </div>

                <button type="submit">
                    Login
                </button>

            </form>

            <div class="demo-info">

                <strong>Demo Login</strong>

                <p>Username: employee01</p>
                <p>Password: employee123</p>

            </div>

        </div>

    </div>

</body>

</html>