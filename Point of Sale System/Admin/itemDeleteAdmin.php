<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" &&
    isset($_POST["variable1"])) {

    // Retrieve the values from the POST data
    $phpVariable1 = $_POST["variable1"];

    // MySQL database connection
  

    $host = "localhost";
    $username = "root";
    $password = "";
    $database = "pointofsale";

    try {
        $conn = new PDO("mysql:host=$host;dbname=$database", $username, $password);
        
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Prepare statement for SQL insertion
        // $stmt = $conn->prepare("INSERT INTO orders (orderAmount, orderCustomerPaid, orderChange, orderCustomerName) VALUES (:variable1, :variable2, :variable3, :variable4)");
        $sql = "DELETE FROM pointofsale.menuitems WHERE menuItemId = :variable1";
        $stmt = $conn->prepare($sql);




        // Bind parameters
        $stmt->bindParam(':variable1', $phpVariable1, PDO::PARAM_INT);
        // $stmt->bindParam(':menuItemId', $menuItemId, PDO::PARAM_INT);


        // Execute statement
        $stmt->execute();

        echo "Data inserted successfully";
        
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

    // Close database connection
    $conn = null;
} else {
    echo "Invalid request";
}
?>