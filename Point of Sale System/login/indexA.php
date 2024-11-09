<?php
session_start();
// if (!isset($_SESSION["user"])) {
//    header("Location: loginA.php");
// }
// print_r($_SESSION);

// Assuming $_SESSION["admin"] is set after checking if the user is an admin
$isAdmin = isset($_SESSION["admin"]) && $_SESSION["admin"];
print_r($_SESSION);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">

   <link rel="stylesheet" href="style.css">
    <title>User Dashboard</title>
</head>
<body>
    <?php
    // Include PHP variable in JavaScript
    echo '<script>var isAdmin = ' . ($isAdmin ? 'true' : 'false') . ';</script>';
    ?>
    <div class="container">
        <h1>Welcome to Dashboard  </h1>
        <a href="logout.php" class="btn btn-warning">Logout</a>
        <span id="valueA" class="text-success fw-3"></span>
    </div>
    <script>
        // Use the isAdmin variable in your JavaScript logic
        console.log('Is admin:', isAdmin);
        document.getElementById('valueA').textContent = isAdmin;
        const adminvalue = isAdmin;
        console.log(adminvalue) 
    </script>

</body>
</html>