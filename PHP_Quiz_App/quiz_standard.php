<?php
    require_once 'pdo.php';
    require_once 'boot.html';
    session_start();

    if(!isset($_SESSION['quiz_started'])){
        header("Location:index.php");
        return;
    }
    if(isset($_POST['medium'])){
        $_SESSION['medium'] = $_POST['medium'];
        header("Location:quiz_standard.php");
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
<h3 style="text-align:center;" class="alert alert-primary" role="alert">Select Your standard:</h3><br><hr>
        
        <?php 
            $stmt = $pdo->query('SELECT DISTINCT std FROM que_ans WHERE medium="'.$_SESSION['medium'].'"');
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach($rows as $row )
            {?>
                <form action="./quiz_subject.php" method="POST">
                    <input class="btn btn-outline-dark btn-lg" style="height:100px;width:100%;" type="submit" name="std" value="<?php echo $row['std'];?>"><br><br>
                </form>
            <?php   
            }

            ?>
        

        <br>
</body>
</html>