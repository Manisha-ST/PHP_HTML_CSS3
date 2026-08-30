<?php

session_start();

$shipmentFolder = "shipments";

/*
 * Create shipment directory if it does not exist.
 */

if (!is_dir($shipmentFolder)) {
    mkdir($shipmentFolder, 0777, true);
}


/*
 * Get all shipment files.
 */

$shipmentFiles = glob($shipmentFolder . "/*.txt");

if ($shipmentFiles === false) {
    $shipmentFiles = [];
}


/*
 * Sort files by latest modified time.
 */

usort(
    $shipmentFiles,
    function ($file1, $file2) {

        return filemtime($file2) - filemtime($file1);

    }
);


/*
 * Read messages.
 */

$successMessage = $_SESSION["success"] ?? "";

$errorMessage = $_SESSION["error"] ?? "";

unset($_SESSION["success"]);

unset($_SESSION["error"]);

?>

<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Shipment Records Management</title>

    <link rel="stylesheet" href="style.css">

</head>

<body>

<div class="container">

    <!-- HEADER -->

    <header>

        <div class="truck">
            🚚
        </div>

        <h1>
            Shipment Records
        </h1>

        <p>
            Shipment File Management System
        </p>

    </header>


    <main>


        <!-- MESSAGES -->

        <?php if ($successMessage !== ""): ?>

            <div class="message success">

                ✓

                <?= htmlspecialchars($successMessage) ?>

            </div>

        <?php endif; ?>


        <?php if ($errorMessage !== ""): ?>

            <div class="message error">

                !

                <?= htmlspecialchars($errorMessage) ?>

            </div>

        <?php endif; ?>


        <!-- ADD SHIPMENT -->

        <section class="form-card">

            <div class="form-heading">

                <div class="box-icon">
                    📦
                </div>

                <div>

                    <h2>
                        Add Shipment Record
                    </h2>

                    <p>
                        Enter the shipment information below.
                    </p>

                </div>

            </div>


            <form
                action="process.php"
                method="POST"
            >

                <input
                    type="hidden"
                    name="action"
                    value="add"
                >


                <div class="form-grid">


                    <div class="form-group">

                        <label for="shipment_id">
                            Shipment ID
                        </label>

                        <input
                            type="text"
                            id="shipment_id"
                            name="shipment_id"
                            placeholder="Example: SH1001"
                            required
                        >

                    </div>


                    <div class="form-group">

                        <label for="customer_name">
                            Customer Name
                        </label>

                        <input
                            type="text"
                            id="customer_name"
                            name="customer_name"
                            placeholder="Enter customer name"
                            required
                        >

                    </div>


                    <div class="form-group">

                        <label for="origin">
                            Origin
                        </label>

                        <input
                            type="text"
                            id="origin"
                            name="origin"
                            placeholder="Enter origin city"
                            required
                        >

                    </div>


                    <div class="form-group">

                        <label for="destination">
                            Destination
                        </label>

                        <input
                            type="text"
                            id="destination"
                            name="destination"
                            placeholder="Enter destination city"
                            required
                        >

                    </div>


                    <div class="form-group">

                        <label for="package_type">
                            Package Type
                        </label>

                        <select
                            id="package_type"
                            name="package_type"
                            required
                        >

                            <option value="">
                                Select package type
                            </option>

                            <option value="Document">
                                Document
                            </option>

                            <option value="Electronics">
                                Electronics
                            </option>

                            <option value="Clothing">
                                Clothing
                            </option>

                            <option value="Food">
                                Food
                            </option>

                            <option value="Other">
                                Other
                            </option>

                        </select>

                    </div>


                    <div class="form-group">

                        <label for="status">
                            Shipment Status
                        </label>

                        <select
                            id="status"
                            name="status"
                            required
                        >

                            <option value="">
                                Select status
                            </option>

                            <option value="Processing">
                                Processing
                            </option>

                            <option value="In Transit">
                                In Transit
                            </option>

                            <option value="Delivered">
                                Delivered
                            </option>

                        </select>

                    </div>


                    <div class="form-group">

                        <label for="shipment_date">
                            Shipment Date
                        </label>

                        <input
                            type="date"
                            id="shipment_date"
                            name="shipment_date"
                            required
                        >

                    </div>


                    <div class="form-group">

                        <label for="weight">
                            Package Weight (kg)
                        </label>

                        <input
                            type="number"
                            id="weight"
                            name="weight"
                            min="0.1"
                            step="0.1"
                            placeholder="Example: 2.5"
                            required
                        >

                    </div>

                </div>


                <button type="submit">

                    + Save Shipment

                </button>

            </form>

        </section>


        <!-- SEARCH -->

        <section class="search-card">

            <div class="search-heading">

                <h2>
                    🔎 Find Shipment
                </h2>

                <p>
                    Enter a Shipment ID to retrieve its record.
                </p>

            </div>


            <form
                action="process.php"
                method="POST"
                class="search-form"
            >

                <input
                    type="hidden"
                    name="action"
                    value="search"
                >


                <input
                    type="text"
                    name="search_id"
                    placeholder="Enter Shipment ID"
                    required
                >


                <button type="submit">
                    Search
                </button>

            </form>

        </section>


        <!-- SUMMARY -->

        <section class="summary">

            <div class="summary-card">

                <div class="summary-icon">
                    📦
                </div>

                <div>

                    <span>
                        Total Shipments
                    </span>

                    <strong>
                        <?= count($shipmentFiles) ?>
                    </strong>

                </div>

            </div>


            <div class="summary-card">

                <div class="summary-icon">
                    📁
                </div>

                <div>

                    <span>
                        Storage Directory
                    </span>

                    <strong>
                        shipments/
                    </strong>

                </div>

            </div>

        </section>


        <!-- SHIPMENT RECORDS -->

        <section class="records-section">

            <div class="records-heading">

                <div>

                    <h2>
                        Shipment Records
                    </h2>

                    <p>
                        All shipment files currently stored.
                    </p>

                </div>

                <div class="record-count">

                    <?= count($shipmentFiles) ?>

                    Records

                </div>

            </div>


            <?php if (empty($shipmentFiles)): ?>

                <div class="empty">

                    <div class="empty-icon">
                        📂
                    </div>

                    <h3>
                        No Shipment Records
                    </h3>

                    <p>
                        Add a shipment using the form above.
                    </p>

                </div>

            <?php else: ?>


                <div class="records">

                    <?php foreach ($shipmentFiles as $file): ?>

                        <?php

                        $fileContent = file_get_contents($file);

                        $fileName = basename($file);

                        ?>

                        <div class="record">

                            <div class="record-icon">
                                🚚
                            </div>

                            <div class="record-content">

                                <h3>
                                    <?= htmlspecialchars($fileName) ?>
                                </h3>

                                <p>
                                    <?= htmlspecialchars($fileContent) ?>
                                </p>

                            </div>

                        </div>

                    <?php endforeach; ?>

                </div>

            <?php endif; ?>

        </section>


        <!-- STORAGE INFORMATION -->

        <section class="info">

            <div class="info-icon">
                🗃️
            </div>

            <div>

                <h3>
                    Shipment File Storage
                </h3>

                <p>
                    Each shipment is stored as a separate text file
                    inside the <strong>shipments</strong> directory.
                    Existing records are preserved when new shipments
                    are added.
                </p>

            </div>

        </section>

    </main>


    <footer>

        Shipment Records File Management System

    </footer>

</div>

</body>

</html>