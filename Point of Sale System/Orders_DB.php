<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" &&
    isset($_POST["variable1"]) &&
    isset($_POST["variable2"]) &&
    isset($_POST["variable3"]) &&
    isset($_POST["variable4"]) &&
    isset($_POST["variable5"])) {

    // Retrieve the values from the POST data
    $phpVariable1 = $_POST["variable1"];
    $phpVariable2 = $_POST["variable2"];
    $phpVariable3 = $_POST["variable3"];
    $phpVariable4 = $_POST["variable4"];
    $phpVariable5 = $_POST["variable5"];

    // MySQL database connection
  

    $host = "localhost";
    $username = "root";
    $password = "";
    $database = "pointofsale";

    try {
        $conn = new PDO("mysql:host=$host;dbname=$database", $username, $password);
        
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Prepare statement for SQL insertion
        $stmt = $conn->prepare("INSERT INTO orders (orderAmount, orderCustomerPaid, orderChange, orderCustomerName, orderID) VALUES (:variable1, :variable2, :variable3, :variable4, :variable5)");

        // Bind parameters
        $stmt->bindParam(':variable1', $phpVariable1, PDO::PARAM_STR);
        $stmt->bindParam(':variable2', $phpVariable2, PDO::PARAM_STR);
        $stmt->bindParam(':variable3', $phpVariable3, PDO::PARAM_STR);
        $stmt->bindParam(':variable4', $phpVariable4, PDO::PARAM_STR);
        $stmt->bindParam(':variable5', $phpVariable5, PDO::PARAM_STR);

        // Execute statement
        $stmt->execute();

        echo "Data inserted successfully in Order";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

    // Close database connection
    $conn = null;
} else {
    echo "Invalid request";
}
?>
