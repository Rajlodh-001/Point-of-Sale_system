<?php
session_start();
if (isset($_SESSION["user"])) {
    header("Location: http://localhost/POS/");
 }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    
    <div class="container">
        <h1 class="pb-5 text-center font-monospace fs-">Login </h1>
        <?php
        // if (isset($_POST["login"])) {
        //    $email = $_POST["email"];
        //    $password = $_POST["password"];
        //     require_once "database.php";
        //     $sql = "SELECT * FROM users WHERE email = '$email'";
        //     $result = mysqli_query($conn, $sql);
        //     $user = mysqli_fetch_array($result, MYSQLI_ASSOC);
        //     if ($user) {
        //         if (password_verify($password, $user["password"])) {
        //             session_start();
        //             $_SESSION["user"] = "yes";
        //             header("Location: index.php");
        //             die();
        //         }else{
        //             echo "<div class='alert alert-danger'>Password does not match</div>";
        //         }
        //     }else{
        //         echo "<div class='alert alert-danger'>Email does not match</div>";
        //     }
        // }

        // -----------------------
        
        if (isset($_POST["login"])) {
            $email = $_POST["email"];
            $password = $_POST["password"];
            require_once "database.php";
        
            $sql = "SELECT * FROM users WHERE email = '$email'";
            $result = mysqli_query($conn, $sql);
            $user = mysqli_fetch_array($result, MYSQLI_ASSOC);
        
            if ($user) {
                if (password_verify($password, $user["password"])) {
                    if ($user["admin"] == 1) {  // Check if the user is an admin (assuming 'admin' column is a boolean)
                        session_start();
                        $_SESSION["user"] = "yes";
                        $_SESSION["admin"] = true;  // Set admin session variable
                        header("Location:  http://localhost/POS/");
                        die();
                    } else {
                        echo "<div class='alert alert-danger'>You are not authorized as an admin</div>";

                        session_start();
                        $_SESSION["user"] = "yes";
                        $_SESSION["admin"] = false;  // Set admin session variable
                        header("Location:  http://localhost/POS/");
                        die();

                    }
                } else {
                    echo "<div class='alert alert-danger'>Password does not match</div>";
                }
            } else {
                echo "<div class='alert alert-danger'>Email does not match</div>";
            }
        }

        ?>
      <form action="login.php" method="post">
        <div class="form-group">
            <input type="email" placeholder="Enter Email:" name="email" class="form-control">
        </div>
        <div class="form-group">
            <input type="password" placeholder="Enter Password:" name="password" class="form-control">
        </div>
        <div class="form-btn">
            <input type="submit" value="Login" name="login" class="btn btn-primary">
        </div>
      </form>
    <div><p class="py-3">Not registered <a href="registration.php">Register Here !!</a></p></div>
   
    </div>
</body>
</html>