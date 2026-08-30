<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Article File Reader</title>

    <link rel="stylesheet" href="style.css">
</head>

<body>

    <div class="container">

        <header>
            <h1>Article File Reader</h1>
            <p>Read and display article information</p>
        </header>

        <main class="card">

            <h2>Article Management</h2>

            <p class="description">
                Click the button below to read the article
                stored in the text file.
            </p>

            <form action="process.php" method="POST">

                <button type="submit">
                    Read Article
                </button>

            </form>

        </main>

    </div>

</body>

</html>