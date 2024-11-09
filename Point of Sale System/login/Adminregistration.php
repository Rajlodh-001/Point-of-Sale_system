<?php
// session_start();
// if (isset($_SESSION["user"])) {
//    header("Location: index.php");
// }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Registration</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">

     <h2 class="pb-5 text-center font-monospace fs-">Admin Registration</h2>
        <?php
        if (isset($_POST["submit"])) {
           $fullName = $_POST["fullname"];
           $email = $_POST["email"];
           $password = $_POST["password"];
           $passwordRepeat = $_POST["repeat_password"];
           $terminal_code = $_POST["terminal_code"];
        //    $terminal_code = ["terminal_code"];
           $adminvalue=1;
        //    $terminal_code;
           
           $passwordHash = password_hash($password, PASSWORD_DEFAULT);

           $errors = array();
           $terminalcode = 14631463;
           
           if (empty($fullName) OR empty($email) OR empty($password) OR empty($passwordRepeat)OR empty($terminal_code)) {
            array_push($errors,"All fields are required");
           }
           if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            array_push($errors, "Email is not valid");
           }
           if (strlen($password)<4) {
            array_push($errors,"Password must be at least 8 charactes long");
           }
           if ($password!==$passwordRepeat) {
            array_push($errors,"Password does not match");
           }
           if(intval($terminal_code) !== $terminalcode){
            array_push($errors," incorrect Terminal Code ");
           }

        //    if($terminal_code !== strval($terminalcode)){
        //     array_push($errors," incorrect Terminal Code ");
        //    }

           require_once "database.php";
           $sql = "SELECT * FROM users WHERE email = '$email'";
           $result = mysqli_query($conn, $sql);
           $rowCount = mysqli_num_rows($result);
           if ($rowCount>0) {
            array_push($errors,"Email already exists!");
           }
           if (count($errors)>0) {
            foreach ($errors as  $error) {
                echo "<div class='alert alert-danger'>$error</div>";
            }
            foreach ($errors as  $error) {                
                echo "<script>
                setTimeout(function() {
                    var errorAlerts = document.getElementsByClassName('alert-danger');
                    for (var i = 0; i < errorAlerts.length; i++) {
                        (function(index) {
                            setTimeout(function() {
                                errorAlerts[index].style.display = 'none';
                            }, 200 + index * 500 );
                        })(i);
                    }
                }, 1000);
              </script>";
            }
           }else{
            
            $sql = "INSERT INTO users (full_name, email, password, admin) VALUES ( ?, ?, ?, ?)";
            $stmt = mysqli_stmt_init($conn);
            $prepareStmt = mysqli_stmt_prepare($stmt,$sql);
            if ($prepareStmt) {
                mysqli_stmt_bind_param($stmt,"sssi",$fullName, $email, $passwordHash, $adminvalue);
                mysqli_stmt_execute($stmt);
                echo "<div class='alert alert-success'>You are registered successfully as Admin.</div>";
                echo "<script>
                setTimeout(function(){
                    document.getElementById('alert-success').style.display='none';
                }, 7000);
              </script>";
            }else{
                die("Something went wrong");
            }
           }
          

        }
        ?>
        <form action="Adminregistration.php" method="post">
            <div class="form-group">
                <input type="text" class="form-control" name="fullname" placeholder="Full Name :">
            </div>
            <div class="form-group">
                <input type="emamil" class="form-control" name="email" placeholder="Email :">
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="password" placeholder="Password :">
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="repeat_password" placeholder="Repeat Password :">
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="terminal_code" placeholder="Terminal Code :">
            </div>
            <div class="form-btn">
                <input type="submit" class="btn btn-primary" value="Register" name="submit">
            </div>
        </form>
        <div>
        <div><p class="pt-4">Already Registered <a href="login.php">Login Here.</a></p></div>
        <div><p class="pt-2">Registration  <a href="http://localhost/POS/login/registration.php">Register Here.</a></p></div>
      </div>
    </div>
</body>
</html>