<?php
    require_once 'pdo.php';
    require_once 'boot.html';
    session_start();
    if(!isset($_SESSION['quiz_started'])){
        header("Location:index.php");
        return;
    }
    if(isset($_POST['chapname'])){
        $_SESSION['chapname'] = $_POST['chapname'];
        header("Location:quiz_quetype.php");
        return;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>quiz</title>
</head>
<body class="container">
<h1 style="text-align:center;" class="alert alert-primary" role="alert">Choose question type</h1><hr>
        
        

            <form action="./quiz_startquiz.php" method="POST">
                     <input class="btn btn-outline-dark btn-lg" style="height:100px;width:100%;"  type="submit" name="quetype" value="MCQ"><br><br><br>
            </form>

            <form action="./quiz_startquiz.php" method="POST">
                     <input class="btn btn-outline-dark btn-lg" style="height:100px;width:100%;"  type="submit" name="quetype" value="Oral test"><br><br><br>
            </form>

            <form action="./quiz_startquiz.php" method="POST">
                     <input class="btn btn-outline-dark btn-lg" style="height:100px;width:100%;"  type="submit" name="quetype" value="Written test"><br><br><br>
            </form>

        <br>
</body>
</html>
