<?php

$documentFolder = "documents";


// Create document folder

if (!is_dir($documentFolder)) {

    mkdir($documentFolder);

}


// Get stored documents

$documents = [];

$files = scandir($documentFolder);

foreach ($files as $file) {

    if (
        $file != "." &&
        $file != ".." &&
        is_file($documentFolder . "/" . $file)
    ) {

        $documents[] = $file;

    }

}


// Message

$message = $_GET["message"] ?? "";

$type = $_GET["type"] ?? "";

?>

<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Cloud Document Manager</title>

    <link rel="stylesheet" href="style.css">

</head>

<body>

<div class="container">

    <header>

        <div class="cloud-icon">
            ☁️
        </div>

        <h1>
            Cloud Document Manager
        </h1>

        <p>
            Upload, store, retrieve and manage your documents
        </p>

    </header>


    <main>

        <?php if ($message != ""): ?>

            <div class="message <?= htmlspecialchars($type) ?>">

                <?= htmlspecialchars($message) ?>

            </div>

        <?php endif; ?>


        <section class="upload-section">

            <div class="section-heading">

                <div class="heading-icon">
                    📤
                </div>

                <div>

                    <h2>
                        Upload Document
                    </h2>

                    <p>
                        Select a document to store in the cloud directory.
                    </p>

                </div>

            </div>


            <form
                action="process.php"
                method="POST"
                enctype="multipart/form-data"
            >

                <div class="form-group">

                    <label for="document">

                        Select Document

                    </label>

                    <input
                        type="file"
                        name="document"
                        id="document"
                        accept=".pdf,.doc,.docx,.txt"
                        required
                    >

                </div>


                <button type="submit"
                        name="action"
                        value="upload">

                    Upload Document

                </button>

            </form>

        </section>


        <section class="documents-section">

            <div class="section-title">

                <div>

                    <h2>
                        📂 Stored Documents
                    </h2>

                    <p>
                        Documents currently available in the directory.
                    </p>

                </div>

                <span class="count">

                    <?= count($documents) ?> Files

                </span>

            </div>


            <?php if (empty($documents)): ?>

                <div class="empty">

                    <div class="empty-icon">
                        📭
                    </div>

                    <h3>
                        No documents available
                    </h3>

                    <p>
                        Upload a document to see it here.
                    </p>

                </div>

            <?php else: ?>

                <div class="document-grid">

                    <?php foreach ($documents as $file): ?>

                        <div class="document-card">

                            <div class="file-icon">
                                📄
                            </div>

                            <h3>

                                <?= htmlspecialchars($file) ?>

                            </h3>

                            <p>
                                Stored Document
                            </p>


                            <div class="actions">

                                <a
                                    href="documents/<?= rawurlencode($file) ?>"
                                    target="_blank"
                                >
                                    View
                                </a>


                                <form
                                    action="process.php"
                                    method="POST"
                                    onsubmit="return confirm('Are you sure you want to delete this document?');"
                                >

                                    <input
                                        type="hidden"
                                        name="filename"
                                        value="<?= htmlspecialchars($file) ?>"
                                    >

                                    <button
                                        type="submit"
                                        name="action"
                                        value="delete"
                                        class="delete-btn"
                                    >
                                        Delete
                                    </button>

                                </form>

                            </div>

                        </div>

                    <?php endforeach; ?>

                </div>

            <?php endif; ?>

        </section>


        <div class="info-box">

            <strong>
                Supported Documents
            </strong>

            <p>
                PDF, DOC, DOCX and TXT files can be uploaded.
                Files are stored inside the documents directory.
            </p>

        </div>

    </main>


    <footer>

        Cloud Document Directory Management System

    </footer>

</div>

</body>

</html>