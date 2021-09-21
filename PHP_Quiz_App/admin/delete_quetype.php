<?php
    require_once '../pdo.php';
    require_once '../boot.html';
    require_once './navbar.php';
    session_start();
    if(!isset($_SESSION['admin_logged_in'])){
        header("location:./adminlogin.php");
        
    }
    if(!isset($_SESSION['delete_started'])){
        header("Location:admin_homepage.php");
        return;
    }
    if(isset($_POST['chapname'])){
        $_SESSION['chapname1'] = $_POST['chapname'];
        header("Location:delete_quetype.php");
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
<h3 class="alert alert-primary" role="alert">Choose question type</h3>
        
        <?php 
            $stmt = $pdo->query('SELECT DISTINCT quetype FROM que_ans WHERE medium="'.$_SESSION['medium1'].'" AND std="'.$_SESSION['std1'].'" AND subject="'.$_SESSION['subject1'].'" AND chapname="'.$_SESSION['chapname1'].'"');
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach($rows as $row )
            {?>
                <form action="./delete_start.php" method="POST">
                    <input class="btn btn-outline-dark btn-lg" style="height:100px;width:100%;"  type="submit" name="quetype" value="<?php echo $row['quetype'];?>"><hr>
                </form>
            <?php   
            }

            ?>
        

        <br>
</body>
</html>
