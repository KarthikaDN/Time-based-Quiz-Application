<?php
    require_once '../pdo.php';
    require_once '../boot.html';
    require_once './navbar.php';
    session_start();

    if(!isset($_SESSION['admin_logged_in'])){
        header("location:./adminlogin.php");
        
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
</head>
<body class="container">
    <h1>Welcome back <?php echo $_SESSION['adminemail'];?></h1> <br>
    <a class="btn btn-outline-success btn-lg" style="width:100%;" href="./update_language.php">Update Questions</a> <br><hr><br>
    <a class="btn btn-outline-danger btn-lg" style="width:100%;" href="./delete_language.php">Delete Questions</a>  <br><hr><br>
    <a class="btn btn-outline-primary btn-lg" style="width:100%;" href="./image_language.php">Add image to questions</a>
</body>
</html>