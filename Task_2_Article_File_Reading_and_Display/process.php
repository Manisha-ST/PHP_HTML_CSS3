<?php

$fileName = "article.txt";

if (!file_exists($fileName)) {
    die("Error: Article file was not found.");
}

$articleContent = file_get_contents($fileName);

if ($articleContent === false) {
    die("Error: Unable to read the article file.");
}

$lines = file($fileName, FILE_IGNORE_NEW_LINES);

if ($lines === false) {
    die("Error: Unable to process the article.");
}

$lineCount = count($lines);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Article Details</title>

    <link rel="stylesheet" href="style.css">
</head>

<body>

    <div class="container">

        <header>
            <h1>Article Details</h1>
            <p>Article content retrieved from file</p>
        </header>

        <main class="result-card">

            <div class="file-info">

                <h2>Article Information</h2>

                <p>
                    <strong>File Name:</strong>
                    <?= htmlspecialchars($fileName) ?>
                </p>

                <p>
                    <strong>Number of Lines:</strong>
                    <?= $lineCount ?>
                </p>

            </div>

            <div class="article-box">

                <h2>Article Content</h2>

                <div class="content">

                    <?php foreach ($lines as $line): ?>

                        <p>
                            <?= htmlspecialchars($line) ?>
                        </p>

                    <?php endforeach; ?>

                </div>

            </div>

            <a href="index.php" class="back-button">
                Back
            </a>

        </main>

    </div>

</body>

</html>