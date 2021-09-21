<?php
    require_once 'pdo.php';
    require_once 'boot.html';
    session_start();
    if(!isset($_SESSION['quiz_started'])){
        header("Location:index.php");
        return;
    }
    if(isset($_POST['std'])){
        $_SESSION['std'] = $_POST['std'];
        header("Location:quiz_subject.php");
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
<h3 style="text-align:center;" class="alert alert-primary" role="alert">Select Your subject</h3><hr>
        
        <?php 
            $stmt = $pdo->query('SELECT DISTINCT subject FROM que_ans WHERE medium="'.$_SESSION['medium'].'" AND std="'.$_SESSION['std'].'"');
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach($rows as $row )
            {?>
                <form action="./quiz_chapter.php" method="POST">
                    <input class="btn btn-outline-success btn-lg" style="height:100px;width:100%;" type="submit" name="subject" value="<?php echo $row['subject'];?>"><br><br><br>
                </form>
            <?php   
            }

            ?>
        

        <br>
</body>
</html>
