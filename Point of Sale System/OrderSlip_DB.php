<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" &&
    isset($_POST["variable11"]) &&
    isset($_POST["variable21"]) &&
    isset($_POST["variable31"]) &&
    isset($_POST["variable41"]) &&
    isset($_POST["variable51"])
    ) {

    // Retrieve the values from the POST data
    $phpVariable1 = $_POST["variable11"];
    $phpVariable2 = $_POST["variable21"];
    $phpVariable3 = $_POST["variable31"];
    $phpVariable4 = $_POST["variable41"];
    $phpVariable5 = $_POST["variable51"];

    // MySQL database connection
  

    $host = "localhost";
    $username = "root";
    $password = "";
    $database = "pointofsale";

    try {
        $conn = new PDO("mysql:host=$host;dbname=$database", $username, $password);
        
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Prepare statement for SQL insertion
        $stmt = $conn->prepare("INSERT INTO orderslips (orderSlipId, orderSlipItemId, orderSlipItemName, orderSlipItemPrice, orderSlipQuantity) VALUES (:variable51, :variable11, :variable21, :variable31, :variable41)");

        // Bind parameters
        $stmt->bindParam(':variable11', $phpVariable1, PDO::PARAM_INT);
        $stmt->bindParam(':variable21', $phpVariable2, PDO::PARAM_STR);
        $stmt->bindParam(':variable31', $phpVariable3, PDO::PARAM_STR);
        $stmt->bindParam(':variable41', $phpVariable4, PDO::PARAM_INT);
        $stmt->bindParam(':variable51', $phpVariable5, PDO::PARAM_INT);

        // Execute statement
        $stmt->execute();

        echo "Data inserted successfully in Order Slip";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

    // Close database connection
    $conn = null;
} else {
    echo "Invalid request";
}
?>
