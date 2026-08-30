<?php

$directory = "departments";

if (!is_dir($directory)) {
    mkdir($directory);
}

$folders = array_diff(
    scandir($directory),
    array(".", "..")
);

$message = $_GET["message"] ?? "";
$type = $_GET["type"] ?? "";

?>

<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Department Directory</title>

    <link rel="stylesheet" href="style.css">

</head>

<body>

<div class="container">

    <header>

        <div class="folder-icon">
            📁
        </div>

        <h1>
            Department Directory
        </h1>

        <p>
            Create, rename and delete department folders
        </p>

    </header>


    <main>

        <?php if ($message != ""): ?>

            <div class="message <?= htmlspecialchars($type) ?>">

                <?= htmlspecialchars($message) ?>

            </div>

        <?php endif; ?>


        <section class="control-panel">

            <h2>
                Directory Management
            </h2>

            <p>
                Select an operation and enter the folder name.
            </p>


            <form
                action="process.php"
                method="POST"
            >

                <div class="form-group">

                    <label for="operation">
                        Select Operation
                    </label>

                    <select
                        name="operation"
                        id="operation"
                        required
                    >

                        <option value="">
                            -- Choose Operation --
                        </option>

                        <option value="create">
                            Create Folder
                        </option>

                        <option value="rename">
                            Rename Folder
                        </option>

                        <option value="delete">
                            Delete Folder
                        </option>

                    </select>

                </div>


                <div class="form-group">

                    <label for="folder_name">
                        Folder Name
                    </label>

                    <input
                        type="text"
                        id="folder_name"
                        name="folder_name"
                        placeholder="Example: Computer Science"
                        required
                    >

                </div>


                <div class="form-group">

                    <label for="new_name">
                        New Name
                        <span>
                            (Only for Rename)
                        </span>
                    </label>

                    <input
                        type="text"
                        id="new_name"
                        name="new_name"
                        placeholder="Enter new folder name"
                    >

                </div>


                <button type="submit">
                    Perform Operation
                </button>

            </form>

        </section>


        <section class="folder-section">

            <div class="section-heading">

                <div>

                    <h2>
                        📂 Department Folders
                    </h2>

                    <p>
                        Folders currently available in the directory
                    </p>

                </div>

                <span class="folder-count">
                    <?= count($folders) ?> Folders
                </span>

            </div>


            <?php if (empty($folders)): ?>

                <div class="empty">

                    <div>
                        📭
                    </div>

                    <h3>
                        No department folders
                    </h3>

                    <p>
                        Create a folder using the form above.
                    </p>

                </div>

            <?php else: ?>

                <div class="folder-grid">

                    <?php foreach ($folders as $folder): ?>

                        <?php if (is_dir($directory . "/" . $folder)): ?>

                            <div class="folder-card">

                                <div class="large-folder">
                                    📁
                                </div>

                                <h3>
                                    <?= htmlspecialchars($folder) ?>
                                </h3>

                                <p>
                                    Department Folder
                                </p>

                            </div>

                        <?php endif; ?>

                    <?php endforeach; ?>

                </div>

            <?php endif; ?>

        </section>


        <div class="note">

            <strong>
                Directory Functions Used:
            </strong>

            <span>
                mkdir() &nbsp; | &nbsp;
                rename() &nbsp; | &nbsp;
                rmdir() &nbsp; | &nbsp;
                scandir()
            </span>

        </div>

    </main>


    <footer>

        PHP Department Document Directory Management

    </footer>

</div>

</body>

</html>