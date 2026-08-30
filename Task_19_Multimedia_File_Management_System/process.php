<?php


/*
 * Allow only POST requests.
 */

if ($_SERVER["REQUEST_METHOD"] !== "POST") {

    header("Location: index.php");

    exit();

}


$category = $_POST["category"] ?? "";


/*
 * Validate category.
 */

if (
    $category !== "images" &&
    $category !== "videos"
) {

    header(
        "Location: index.php?message=Please select a valid category.&type=error"
    );

    exit();

}


/*
 * Check uploaded file.
 */

if (
    !isset($_FILES["media_file"]) ||
    $_FILES["media_file"]["error"] !== UPLOAD_ERR_OK
) {

    header(
        "Location: index.php?message=Please select a valid multimedia file.&type=error"
    );

    exit();

}


$file = $_FILES["media_file"];

$fileName = basename(
    $file["name"]
);

$fileSize = $file["size"];

$tmpName = $file["tmp_name"];


/*
 * Maximum file size: 20 MB.
 */

$maxSize = 20 * 1024 * 1024;

if ($fileSize > $maxSize) {

    header(
        "Location: index.php?message=File size must not exceed 20 MB.&type=error"
    );

    exit();

}


/*
 * Get file extension.
 */

$extension = strtolower(
    pathinfo(
        $fileName,
        PATHINFO_EXTENSION
    )
);


/*
 * Allowed image types.
 */

$imageExtensions = [

    "jpg",
    "jpeg",
    "png",
    "gif",
    "webp"

];


/*
 * Allowed video types.
 */

$videoExtensions = [

    "mp4",
    "webm",
    "mov"

];


/*
 * Check category and extension.
 */

if (
    $category === "images" &&
    !in_array($extension, $imageExtensions)
) {

    header(
        "Location: index.php?message=Invalid image format. Use JPG, PNG, GIF or WEBP.&type=error"
    );

    exit();

}


if (
    $category === "videos" &&
    !in_array($extension, $videoExtensions)
) {

    header(
        "Location: index.php?message=Invalid video format. Use MP4, WEBM or MOV.&type=error"
    );

    exit();

}


/*
 * Create destination folder.
 */

if (!is_dir($category)) {

    mkdir($category);

}


/*
 * Create a unique file name.
 */

$baseName = pathinfo(
    $fileName,
    PATHINFO_FILENAME
);

$baseName = preg_replace(
    "/[^a-zA-Z0-9_-]/",
    "_",
    $baseName
);


$newFileName =
    $baseName .
    "_" .
    time() .
    "." .
    $extension;


$destination =
    $category .
    "/" .
    $newFileName;


/*
 * Move uploaded file.
 */

if (
    move_uploaded_file(
        $tmpName,
        $destination
    )
) {

    header(
        "Location: index.php?message=File uploaded successfully.&type=success"
    );

    exit();

}


header(
    "Location: index.php?message=File upload failed.&type=error"
);

exit();

?>