<?php
    require_once '../pdo.php';
    require_once '../boot.html';
    require_once './navbar.php';
    session_start();
    if(!isset($_SESSION['admin_logged_in'])){
        header("location:./adminlogin.php");
        
    }
    $_SESSION['delete_started'] = true;

    if(!isset($_SESSION['delete_started'])){
        header("Location:admin_homepage.php");
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
    <h2 class="alert alert-primary" role="alert">Choose your language</h2><br>
    <?php 
            $stmt = $pdo->query("SELECT DISTINCT medium FROM que_ans");
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach($rows as $row )
            {?>
                <form action="./delete_standard.php" method="POST">
                    <input class="btn btn-outline-dark btn-lg" style="height:100px;width:100%;" type="submit" name="medium" value="<?php echo $row['medium'];?>"><hr>
                </form>
            <?php   
            }

            ?>
</body>
</html>