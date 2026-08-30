<?php

session_start();


$shipmentFolder = "shipments";


/*
 * Create shipment directory.
 */

if (!is_dir($shipmentFolder)) {

    if (!mkdir($shipmentFolder, 0777, true)) {

        $_SESSION["error"] =
            "Unable to create shipment directory.";

        header("Location: index.php");

        exit();

    }

}


/*
 * Check POST request.
 */

if ($_SERVER["REQUEST_METHOD"] !== "POST") {

    header("Location: index.php");

    exit();

}


$action = $_POST["action"] ?? "";


/*
 * ADD SHIPMENT
 */

if ($action === "add") {


    $shipmentId = trim(
        $_POST["shipment_id"] ?? ""
    );

    $customerName = trim(
        $_POST["customer_name"] ?? ""
    );

    $origin = trim(
        $_POST["origin"] ?? ""
    );

    $destination = trim(
        $_POST["destination"] ?? ""
    );

    $packageType = trim(
        $_POST["package_type"] ?? ""
    );

    $status = trim(
        $_POST["status"] ?? ""
    );

    $shipmentDate = trim(
        $_POST["shipment_date"] ?? ""
    );

    $weight = trim(
        $_POST["weight"] ?? ""
    );


    /*
     * Validate required fields.
     */

    if (
        $shipmentId === "" ||
        $customerName === "" ||
        $origin === "" ||
        $destination === "" ||
        $packageType === "" ||
        $status === "" ||
        $shipmentDate === "" ||
        $weight === ""
    ) {

        $_SESSION["error"] =
            "Please fill in all the required fields.";

        header("Location: index.php");

        exit();

    }


    /*
     * Validate Shipment ID.
     */

    if (!preg_match(
        "/^[A-Za-z0-9-]+$/",
        $shipmentId
    )) {

        $_SESSION["error"] =
            "Invalid Shipment ID.";

        header("Location: index.php");

        exit();

    }


    /*
     * Validate customer name.
     */

    if (!preg_match(
        "/^[a-zA-Z ]+$/",
        $customerName
    )) {

        $_SESSION["error"] =
            "Customer name should contain only letters.";

        header("Location: index.php");

        exit();

    }


    /*
     * Validate weight.
     */

    if (!is_numeric($weight) || $weight <= 0) {

        $_SESSION["error"] =
            "Please enter a valid package weight.";

        header("Location: index.php");

        exit();

    }


    /*
     * Prevent unsafe file names.
     */

    $safeShipmentId = preg_replace(
        "/[^A-Za-z0-9_-]/",
        "_",
        $shipmentId
    );


    /*
     * Create a separate file for the shipment.
     */

    $shipmentFile =
        $shipmentFolder .
        "/" .
        $safeShipmentId .
        ".txt";


    /*
     * Prevent duplicate shipment records.
     */

    if (file_exists($shipmentFile)) {

        $_SESSION["error"] =
            "Shipment ID already exists.";

        header("Location: index.php");

        exit();

    }


    /*
     * Prepare shipment information.
     */

    $record =
        "Shipment ID: " . $shipmentId . PHP_EOL .
        "Customer: " . $customerName . PHP_EOL .
        "Origin: " . $origin . PHP_EOL .
        "Destination: " . $destination . PHP_EOL .
        "Package Type: " . $packageType . PHP_EOL .
        "Status: " . $status . PHP_EOL .
        "Shipment Date: " . $shipmentDate . PHP_EOL .
        "Weight: " . $weight . " kg" . PHP_EOL .
        "Created On: " . date("d-m-Y h:i:s A") . PHP_EOL;


    /*
     * Write the record to the file.
     */

    $result = file_put_contents(
        $shipmentFile,
        $record,
        LOCK_EX
    );


    if ($result === false) {

        $_SESSION["error"] =
            "Unable to save shipment record.";

    } else {

        $_SESSION["success"] =
            "Shipment record saved successfully.";

    }


    header("Location: index.php");

    exit();

}


/*
 * SEARCH SHIPMENT
 */

if ($action === "search") {


    $searchId = trim(
        $_POST["search_id"] ?? ""
    );


    if ($searchId === "") {

        $_SESSION["error"] =
            "Please enter a Shipment ID.";

        header("Location: index.php");

        exit();

    }


    /*
     * Convert the ID into a safe file name.
     */

    $safeSearchId = preg_replace(
        "/[^A-Za-z0-9_-]/",
        "_",
        $searchId
    );


    $searchFile =
        $shipmentFolder .
        "/" .
        $safeSearchId .
        ".txt";


    /*
     * Check whether the shipment exists.
     */

    if (file_exists($searchFile)) {

        $content = file_get_contents(
            $searchFile
        );


        $_SESSION["search_result"] =
            $content;


        $_SESSION["search_id"] =
            $searchId;


    } else {

        $_SESSION["error"] =
            "Shipment record not found.";

    }


    header("Location: search_result.php");

    exit();

}


/*
 * Invalid action.
 */

$_SESSION["error"] =
    "Invalid request.";

header("Location: index.php");

exit();

?>