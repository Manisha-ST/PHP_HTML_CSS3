<?php

$directory = "departments";


/*
 * Create the main directory
 * if it does not exist.
 */

if (!is_dir($directory)) {

    mkdir($directory);

}


/*
 * Allow only POST requests.
 */

if ($_SERVER["REQUEST_METHOD"] !== "POST") {

    header(
        "Location: index.php"
    );

    exit();

}


$operation = $_POST["operation"] ?? "";

$folderName = trim(
    $_POST["folder_name"] ?? ""
);

$newName = trim(
    $_POST["new_name"] ?? ""
);


/*
 * Validate folder name.
 */

if ($folderName === "") {

    header(
        "Location: index.php?message=Please enter a folder name.&type=error"
    );

    exit();

}


/*
 * Allow only safe folder names.
 */

if (!preg_match(
    "/^[a-zA-Z0-9 _-]+$/",
    $folderName
)) {

    header(
        "Location: index.php?message=Invalid folder name. Use letters, numbers, spaces, hyphens or underscores.&type=error"
    );

    exit();

}


$folderPath =
    $directory . "/" . $folderName;


/*
 * CREATE FOLDER
 */

if ($operation === "create") {

    if (is_dir($folderPath)) {

        header(
            "Location: index.php?message=Folder already exists.&type=error"
        );

        exit();

    }


    if (mkdir($folderPath)) {

        header(
            "Location: index.php?message=Folder created successfully.&type=success"
        );

        exit();

    }


    header(
        "Location: index.php?message=Unable to create folder.&type=error"
    );

    exit();

}


/*
 * RENAME FOLDER
 */

if ($operation === "rename") {


    if (!is_dir($folderPath)) {

        header(
            "Location: index.php?message=Folder not found.&type=error"
        );

        exit();

    }


    if ($newName === "") {

        header(
            "Location: index.php?message=Please enter a new folder name.&type=error"
        );

        exit();

    }


    if (!preg_match(
        "/^[a-zA-Z0-9 _-]+$/",
        $newName
    )) {

        header(
            "Location: index.php?message=Invalid new folder name.&type=error"
        );

        exit();

    }


    $newPath =
        $directory . "/" . $newName;


    if (is_dir($newPath)) {

        header(
            "Location: index.php?message=The new folder name already exists.&type=error"
        );

        exit();

    }


    if (rename(
        $folderPath,
        $newPath
    )) {

        header(
            "Location: index.php?message=Folder renamed successfully.&type=success"
        );

        exit();

    }


    header(
        "Location: index.php?message=Unable to rename folder.&type=error"
    );

    exit();

}


/*
 * DELETE FOLDER
 */

if ($operation === "delete") {


    if (!is_dir($folderPath)) {

        header(
            "Location: index.php?message=Folder not found.&type=error"
        );

        exit();

    }


    /*
     * rmdir() deletes an empty directory.
     */

    if (rmdir($folderPath)) {

        header(
            "Location: index.php?message=Folder deleted successfully.&type=success"
        );

        exit();

    }


    header(
        "Location: index.php?message=Folder could not be deleted. Make sure it is empty.&type=error"
    );

    exit();

}


/*
 * Invalid operation
 */

header(
    "Location: index.php?message=Please select a valid operation.&type=error"
);

exit();

?>