<?php

session_start();

$documentFolder = "secure_documents";


// Create secure document folder

if (!is_dir($documentFolder)) {

    mkdir($documentFolder);

}


// Set default user

if (!isset($_SESSION["username"])) {

    $_SESSION["username"] = "Admin";

}


// Get documents

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


// Get message

$message = $_GET["message"] ?? "";

$type = $_GET["type"] ?? "";

?>

<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Secure Document Management
    </title>

    <link rel="stylesheet" href="style.css">

</head>

<body>

<div class="container">

    <header>

        <div class="icon">
            🔐
        </div>

        <h1>
            Secure Document Management
        </h1>

        <p>
            Upload and manage documents securely
        </p>

    </header>


    <main>

        <div class="user-bar">

            <span>
                👤 Logged in as:
                <strong>
                    <?= htmlspecialchars($_SESSION["username"]) ?>
                </strong>
            </span>

            <span class="secure">
                🔒 Secure Access
            </span>

        </div>


        <?php if ($message != ""): ?>

            <div class="message <?= htmlspecialchars($type) ?>">

                <?= htmlspecialchars($message) ?>

            </div>

        <?php endif; ?>


        <!-- Upload Section -->

        <section class="upload-card">

            <div class="heading">

                <div class="heading-icon">
                    📤
                </div>

                <div>

                    <h2>
                        Upload Document
                    </h2>

                    <p>
                        Upload a document to the secure storage area.
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

                    <small>

                        Allowed formats:
                        PDF, DOC, DOCX and TXT.
                        Maximum size: 5 MB.

                    </small>

                </div>


                <button
                    type="submit"
                    name="action"
                    value="upload"
                >

                    🔒 Secure Upload

                </button>

            </form>

        </section>


        <!-- Document List -->

        <section class="documents">

            <div class="section-heading">

                <div>

                    <h2>
                        📁 Secure Documents
                    </h2>

                    <p>
                        Only authorized users can access these files.
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
                        No Documents
                    </h3>

                    <p>
                        Securely uploaded documents will appear here.
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
                                Secure Document
                            </p>


                            <div class="buttons">

                                <a
                                    href="process.php?action=view&file=<?= urlencode($file) ?>"
                                >
                                    View
                                </a>


                                <form
                                    action="process.php"
                                    method="POST"
                                    onsubmit="return confirm('Delete this document?');"
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
                                        class="delete"
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


        <!-- Security Information -->

        <section class="security-box">

            <h2>
                🛡️ Security Features
            </h2>

            <div class="security-grid">

                <div>
                    <strong>
                        Duplicate Prevention
                    </strong>

                    <p>
                        Duplicate filenames are rejected.
                    </p>
                </div>


                <div>
                    <strong>
                        File Validation
                    </strong>

                    <p>
                        Only permitted file types are accepted.
                    </p>
                </div>


                <div>
                    <strong>
                        Access Protection
                    </strong>

                    <p>
                        Files are accessed through PHP.
                    </p>
                </div>


                <div>
                    <strong>
                        Safe Filenames
                    </strong>

                    <p>
                        Unsafe characters are removed.
                    </p>
                </div>

            </div>

        </section>

    </main>


    <footer>

        Secure Document Management System

    </footer>

</div>

</body>

</html>