<?php
    require_once 'pdo.php';
    require_once 'boot.html';
    session_start();
    if(!isset($_SESSION['quiz_started'])){
        header("Location:index.php");
        return;
    }
    if(isset($_POST['subject'])){
        $_SESSION['subject'] = $_POST['subject'];
        header("Location:quiz_chapter.php");
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
<h3 style="text-align:center;" class="alert alert-primary" role="alert">Select Your Chapter</h3><hr>
        
        <?php 
            $stmt = $pdo->query('SELECT DISTINCT chapname FROM que_ans WHERE medium="'.$_SESSION['medium'].'" AND std="'.$_SESSION['std'].'" AND subject="'.$_SESSION['subject'].'"');
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach($rows as $row )
            {?>
                <form action="./quiz_quetype.php" method="POST">
                    <input class="btn btn-outline-secondary btn-lg" style="height:100px;width:100%;"  type="submit" name="chapname" value="<?php echo $row['chapname'];?>"><br><br><br>
                </form>
            <?php   
            }

            ?>
        

        <br>
</body>
</html>
