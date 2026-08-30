<?php

$resumeFolder = "resumes";


// Create resume folder

if (!is_dir($resumeFolder)) {

    mkdir($resumeFolder);

}


// Get uploaded resumes

$resumes = [];

$files = scandir($resumeFolder);

foreach ($files as $file) {

    if (
        $file != "." &&
        $file != ".." &&
        is_file($resumeFolder . "/" . $file)
    ) {

        $resumes[] = $file;

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

    <title>Resume Upload Validation</title>

    <link rel="stylesheet" href="style.css">

</head>

<body>

<div class="container">

    <header>

        <div class="icon">
            📄
        </div>

        <h1>
            Resume Upload Portal
        </h1>

        <p>
            Upload and validate your resume securely
        </p>

    </header>


    <main>

        <?php if ($message != ""): ?>

            <div class="message <?= htmlspecialchars($type) ?>">

                <?= htmlspecialchars($message) ?>

            </div>

        <?php endif; ?>


        <section class="upload-card">

            <div class="title">

                <div class="title-icon">
                    📤
                </div>

                <div>

                    <h2>
                        Upload Your Resume
                    </h2>

                    <p>
                        Submit your resume for job application.
                    </p>

                </div>

            </div>


            <form
                action="process.php"
                method="POST"
                enctype="multipart/form-data"
            >

                <div class="form-group">

                    <label for="applicant">

                        Applicant Name

                    </label>

                    <input
                        type="text"
                        name="applicant"
                        id="applicant"
                        placeholder="Enter your full name"
                        required
                    >

                </div>


                <div class="form-group">

                    <label for="resume">

                        Select Resume

                    </label>

                    <input
                        type="file"
                        name="resume"
                        id="resume"
                        accept=".pdf,.doc,.docx"
                        required
                    >

                    <small>
                        Accepted formats: PDF, DOC, DOCX
                        | Maximum size: 5 MB
                    </small>

                </div>


                <button type="submit">

                    Upload Resume

                </button>

            </form>

        </section>


        <section class="validation-info">

            <h2>
                ✅ File Validation Rules
            </h2>

            <div class="rules">

                <div>
                    <strong>
                        PDF
                    </strong>

                    <span>
                        Allowed
                    </span>
                </div>


                <div>
                    <strong>
                        DOC
                    </strong>

                    <span>
                        Allowed
                    </span>
                </div>


                <div>
                    <strong>
                        DOCX
                    </strong>

                    <span>
                        Allowed
                    </span>
                </div>


                <div>
                    <strong>
                        File Size
                    </strong>

                    <span>
                        Maximum 5 MB
                    </span>
                </div>

            </div>

        </section>


        <section class="resume-list">

            <div class="section-heading">

                <div>

                    <h2>
                        📁 Submitted Resumes
                    </h2>

                    <p>
                        Valid resumes uploaded to the system.
                    </p>

                </div>

                <span>
                    <?= count($resumes) ?> Files
                </span>

            </div>


            <?php if (empty($resumes)): ?>

                <div class="empty">

                    <div>
                        📭
                    </div>

                    <h3>
                        No resumes uploaded
                    </h3>

                    <p>
                        Uploaded resumes will appear here.
                    </p>

                </div>

            <?php else: ?>

                <div class="resume-grid">

                    <?php foreach ($resumes as $resume): ?>

                        <div class="resume-item">

                            <div class="file-icon">
                                📑
                            </div>

                            <h3>
                                <?= htmlspecialchars($resume) ?>
                            </h3>

                            <p>
                                Validated Resume
                            </p>

                            <a
                                href="resumes/<?= rawurlencode($resume) ?>"
                                target="_blank"
                            >
                                View Resume
                            </a>

                        </div>

                    <?php endforeach; ?>

                </div>

            <?php endif; ?>

        </section>


        <div class="note">

            <strong>
                Validation Status
            </strong>

            <p>
                Only valid PDF, DOC and DOCX resume files
                within the allowed file size are accepted.
                Invalid submissions are rejected with an
                appropriate error message.
            </p>

        </div>

    </main>


    <footer>

        Resume Upload Validation System

    </footer>

</div>

</body>

</html>