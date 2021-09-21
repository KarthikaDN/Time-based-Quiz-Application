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
    if(isset($_POST['subject'])){
        $_SESSION['subject1'] = $_POST['subject'];
        header("Location:delete_chapter.php");
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
<h3 class="alert alert-primary" role="alert">Select Your Chapter</h3>
        
        <?php 
            $stmt = $pdo->query('SELECT DISTINCT chapname FROM que_ans WHERE medium="'.$_SESSION['medium1'].'" AND std="'.$_SESSION['std1'].'" AND subject="'.$_SESSION['subject1'].'"');
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach($rows as $row )
            {?>
                <form action="./delete_quetype.php" method="POST">
                    <input class="btn btn-outline-dark btn-lg" style="height:100px;width:100%;"  type="submit" name="chapname" value="<?php echo $row['chapname'];?>"><hr>
                </form>
            <?php   
            }

            ?>
        

        <br>
</body>
</html>
