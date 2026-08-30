<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Customer Visit Tracking</title>

    <link rel="stylesheet" href="style.css">
</head>

<body>

    <div class="container">

        <header>
            <h1>Customer Visit Tracking</h1>
            <p>Welcome to our website</p>
        </header>

        <div class="card">

            <h2>Customer Preferences</h2>

            <form action="process.php" method="POST">

                <div class="form-group">
                    <label for="customer_name">
                        Customer Name
                    </label>

                    <input
                        type="text"
                        id="customer_name"
                        name="customer_name"
                        placeholder="Enter your name"
                        required
                    >
                </div>

                <div class="form-group">
                    <label for="preference">
                        Select Your Preference
                    </label>

                    <select
                        id="preference"
                        name="preference"
                        required
                    >
                        <option value="">-- Select --</option>
                        <option value="Technology">Technology</option>
                        <option value="Education">Education</option>
                        <option value="Music">Music</option>
                        <option value="Travel">Travel</option>
                    </select>
                </div>

                <button type="submit">
                    Continue
                </button>

            </form>

        </div>

    </div>

</body>

</html>