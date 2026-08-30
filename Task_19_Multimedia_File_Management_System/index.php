<?php

$imageFolder = "images";
$videoFolder = "videos";


// Create folders if they do not exist

if (!is_dir($imageFolder)) {
    mkdir($imageFolder);
}

if (!is_dir($videoFolder)) {
    mkdir($videoFolder);
}


// Get files from folders

$imageFiles = [];

$videoFiles = [];


// Read image files

$allImages = scandir($imageFolder);

foreach ($allImages as $file) {

    if (
        $file != "." &&
        $file != ".." &&
        is_file($imageFolder . "/" . $file)
    ) {

        $imageFiles[] = $file;

    }

}


// Read video files

$allVideos = scandir($videoFolder);

foreach ($allVideos as $file) {

    if (
        $file != "." &&
        $file != ".." &&
        is_file($videoFolder . "/" . $file)
    ) {

        $videoFiles[] = $file;

    }

}


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

    <title>Multimedia File Management</title>

    <link rel="stylesheet" href="style.css">

</head>

<body>

<div class="container">

    <header>

        <div class="media-icon">
            🎬
        </div>

        <h1>
            Multimedia File Manager
        </h1>

        <p>
            Organize, upload and search your multimedia files
        </p>

    </header>


    <main>

        <?php if ($message != ""): ?>

            <div class="message <?= htmlspecialchars($type) ?>">

                <?= htmlspecialchars($message) ?>

            </div>

        <?php endif; ?>


        <section class="upload-box">

            <div class="heading">

                <div class="heading-icon">
                    📤
                </div>

                <div>

                    <h2>
                        Upload Multimedia
                    </h2>

                    <p>
                        Add an image or video to the appropriate category.
                    </p>

                </div>

            </div>


            <form
                action="process.php"
                method="POST"
                enctype="multipart/form-data"
            >

                <div class="form-grid">

                    <div class="form-group">

                        <label for="category">
                            Select Category
                        </label>

                        <select
                            name="category"
                            id="category"
                            required
                        >

                            <option value="">
                                -- Select Category --
                            </option>

                            <option value="images">
                                🖼️ Images
                            </option>

                            <option value="videos">
                                🎥 Videos
                            </option>

                        </select>

                    </div>


                    <div class="form-group">

                        <label for="media_file">
                            Select File
                        </label>

                        <input
                            type="file"
                            name="media_file"
                            id="media_file"
                            accept="image/*,video/*"
                            required
                        >

                    </div>

                </div>


                <button type="submit">

                    Upload File

                </button>

            </form>

        </section>


        <section class="search-box">

            <div class="heading">

                <div class="heading-icon">
                    🔍
                </div>

                <div>

                    <h2>
                        Search Multimedia
                    </h2>

                    <p>
                        Search for images and videos by file name.
                    </p>

                </div>

            </div>


            <form
                action="index.php"
                method="GET"
                class="search-form"
            >

                <input
                    type="text"
                    name="search"
                    placeholder="Enter file name..."
                    value="<?= htmlspecialchars($_GET["search"] ?? "") ?>"
                >

                <button type="submit">
                    Search
                </button>

            </form>

        </section>


        <?php

        $search = strtolower(
            trim($_GET["search"] ?? "")
        );


        $filteredImages = $imageFiles;

        $filteredVideos = $videoFiles;


        if ($search != "") {

            $filteredImages = array_filter(
                $imageFiles,
                function ($file) use ($search) {

                    return strpos(
                        strtolower($file),
                        $search
                    ) !== false;

                }
            );


            $filteredVideos = array_filter(
                $videoFiles,
                function ($file) use ($search) {

                    return strpos(
                        strtolower($file),
                        $search
                    ) !== false;

                }
            );

        }

        ?>


        <section class="media-section">

            <div class="section-title">

                <div>

                    <h2>
                        🖼️ Images
                    </h2>

                    <p>
                        Stored image files
                    </p>

                </div>

                <span>
                    <?= count($filteredImages) ?> Files
                </span>

            </div>


            <?php if (empty($filteredImages)): ?>

                <div class="empty">

                    <div>
                        🖼️
                    </div>

                    <h3>
                        No images found
                    </h3>

                    <p>
                        Upload an image or try another search.
                    </p>

                </div>

            <?php else: ?>

                <div class="file-grid">

                    <?php foreach ($filteredImages as $file): ?>

                        <div class="file-card">

                            <div class="file-icon">
                                🖼️
                            </div>

                            <h3>
                                <?= htmlspecialchars($file) ?>
                            </h3>

                            <p>
                                Image File
                            </p>

                            <a
                                href="images/<?= rawurlencode($file) ?>"
                                target="_blank"
                            >
                                View File
                            </a>

                        </div>

                    <?php endforeach; ?>

                </div>

            <?php endif; ?>

        </section>


        <section class="media-section">

            <div class="section-title">

                <div>

                    <h2>
                        🎥 Videos
                    </h2>

                    <p>
                        Stored video files
                    </p>

                </div>

                <span>
                    <?= count($filteredVideos) ?> Files
                </span>

            </div>


            <?php if (empty($filteredVideos)): ?>

                <div class="empty">

                    <div>
                        🎥
                    </div>

                    <h3>
                        No videos found
                    </h3>

                    <p>
                        Upload a video or try another search.
                    </p>

                </div>

            <?php else: ?>

                <div class="file-grid">

                    <?php foreach ($filteredVideos as $file): ?>

                        <div class="file-card">

                            <div class="file-icon">
                                🎥
                            </div>

                            <h3>
                                <?= htmlspecialchars($file) ?>
                            </h3>

                            <p>
                                Video File
                            </p>

                            <a
                                href="videos/<?= rawurlencode($file) ?>"
                                target="_blank"
                            >
                                View File
                            </a>

                        </div>

                    <?php endforeach; ?>

                </div>

            <?php endif; ?>

        </section>


        <div class="summary">

            <div>

                <strong>
                    <?= count($imageFiles) ?>
                </strong>

                <span>
                    Images
                </span>

            </div>


            <div>

                <strong>
                    <?= count($videoFiles) ?>
                </strong>

                <span>
                    Videos
                </span>

            </div>


            <div>

                <strong>
                    <?= count($imageFiles) + count($videoFiles) ?>
                </strong>

                <span>
                    Total Files
                </span>

            </div>

        </div>

    </main>


    <footer>

        Multimedia File Management System

    </footer>

</div>

</body>

</html>