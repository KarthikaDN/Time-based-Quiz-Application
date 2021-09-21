<?php
    require_once 'pdo.php';
    require_once 'boot.html';
    session_start();

    $_SESSION['quiz_started'] = true;

    if(!isset($_SESSION['quiz_started'])){
        header("Location:index.php");
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
    <h2 class="alert alert-primary" role="alert" style="text-align:center">Choose your language</h2><br>
    <?php 
            $stmt = $pdo->query("SELECT DISTINCT medium FROM que_ans");
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach($rows as $row )
            {?>
                <form action="./quiz_standard.php" method="POST">
                    <input class="btn btn-outline-primary btn-lg btn-block" style="height:100px;width:100%;" type="submit" name="medium" value="<?php echo $row['medium'];?>"><br><br><br>
                </form>
            <?php   
            }

            ?>
</body>
</html>