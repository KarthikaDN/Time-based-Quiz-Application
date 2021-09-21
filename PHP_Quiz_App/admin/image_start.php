<?php
    require_once '../pdo.php';
    require_once '../boot.html';
    require_once './navbar.php';
    session_start();
    if(!isset($_SESSION['admin_logged_in'])){
        header("location:./adminlogin.php");
        
    }
    unset($_SESSION['image_update_started']);
    if(isset($_POST['quetype'])){
        $_SESSION['quetype2'] = $_POST['quetype'];
        header("Location:image_start.php");
        return;
    }

    if(isset($_POST['up_image'])){
        foreach($_POST as $k=>$v){
            if(is_int($k)){
                $qno_to_image = $k;
            }
        }
        $filename = $_FILES["image"]["name"];
        $tempname = $_FILES["image"]["tmp_name"];
        $folder = "pictures/".$filename;
            
        $sql = "UPDATE que_ans SET diagram=:img WHERE srno=:qno";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(
            ':img' => $filename,
            ':qno' => $qno_to_image
            
        ));
        if(move_uploaded_file($tempname,$folder)){
            $_SESSION['image_success'] = "Image Uploaded successfully.";
        }
        else{
            $_SESSION['image_failure'] = "Sorry! Could not upload image!";
        }

        header("Location:image_start.php");
        return;
    }
    
    if(isset($_POST['delimage'])){
        $sql = "UPDATE que_ans SET diagram=:img WHERE srno=:qno";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(
            ':img' => NULL,
            ':qno' => $_POST['question_no']
            
        ));
        header("Location:image_start.php");
        return;
    }

    
    
?>
<html>
<body class="container">

<h3><?php echo $_SESSION['quetype2'];?></h3><hr><br><br><br>
        <?php
            if(isset($_SESSION['image_success'])){
                echo "<h2 style=\"color:steelblue;\">".$_SESSION['image_success']."</h2>";
                unset($_SESSION['image_success']);
            }
            if(isset($_SESSION['image_failure'])){
                echo "<h2 style=\"color:steelblue;\">".$_SESSION['image_failure']."</h2>";
                unset($_SESSION['image_failure']);
            }
        ?>

        <?php 
            $stmt = $pdo->query('SELECT DISTINCT srno,question,answer,option1,option2,option3,option4,diagram FROM que_ans WHERE medium="'.$_SESSION['medium2'].'" AND std="'.$_SESSION['std2'].'" AND subject="'.$_SESSION['subject2'].'" AND chapname="'.$_SESSION['chapname2'].'" AND quetype="'.$_SESSION['quetype2'].'" ORDER BY RAND()');
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if(count($rows) == 0){
                echo "<h1>Sorry! There are no questions!</h1><br><h2>Please choose different type of question.</h2>";
                return;
            }
            
            
        
               
                        
                
                    $c=1;
                    foreach($rows as $row){
                        if(($row['option1'] == NULL) && ($row['option2'] == NULL)){
                            $srno = $row['srno'];
                            $q=$row['question'];
                            
                            $correct_answer = $row['answer'];

                            $diagram = $row['diagram'];
                            
                            echo '<form action="" class="form-group" name="qform" method="POST" enctype="multipart/form-data">';
                            echo "<h2>".$c.")Question </h2>"; echo '<h4><textarea rows="3" cols="50" class="answers" type="text" name="'.$srno.'" value="'.$q.'" >'.$q.'</textarea></h4>' ;echo "<br><br>";
                            echo '<img src="pictures/'.$diagram.'" alt="image" style="width:228px;height:228px;">';echo "<br><br>";
                            echo "Answer &nbsp;&nbsp;&nbsp;";echo '<textarea rows="6" cols="50" class="answers" type="text" value="'.$correct_answer.'" >'.$correct_answer.'</textarea>' ;echo "<br><br>";
                            
                            echo '<input type="file" name="image">';echo "<br><br>";
                            echo '<input class="btn btn-success" type="submit" id="submiquiztbtn" name="up_image" value="Upload image">';
                            echo '</form>';

                            echo '<form action="" class="form-group" name="del" method="POST" >';
                            echo '<input type="hidden" name="question_no" value="'.$srno.'">';
                            echo '<input class="btn btn-danger" type="submit" id="submiquiztbtn" name="delimage" value="Delete image">';
                            echo '</form>';
                            echo "<hr>";
                            $c++;
                            
                        }
                        else{
                            $srno = $row['srno'];
                            $q=$row['question'];
                            $option1 = $row['option1'];
                            $option2 = $row['option2'];
                            $option3 = $row['option3'];
                            $option4 = $row['option4'];
                            $correct_answer = $row['answer'];
                            $diagram = $row['diagram'];
                            
                            echo '<form action="" class="form-group" name="qform" method="POST" enctype="multipart/form-data">';
                            echo "<h2>".$c.")Question </h2>"; echo '<h4><textarea rows="3" cols="50" class="answers" type="text" name="'.$srno.'" value="'.$q.'" readonly>'.$q.'</textarea></h4>' ;echo "<br><br>";
                            echo '<img src="pictures/'.$diagram.'" alt="image" style="width:228px;height:228px;">';echo "<br><br>";
                            echo "option1 &nbsp;&nbsp;&nbsp;";echo '<input class="answers" type="text" value="'.$option1.'" readonly>' ;echo "<br><br>"; 
                            echo "option2 &nbsp;&nbsp;";echo '<input class="answers" type="text" value="'.$option2.'" readonly>' ;echo "<br><br>"; 
                            echo "option3 &nbsp;&nbsp;";echo '<input class="answers" type="text" value="'.$option3.'" readonly>' ;echo "<br><br>"; 
                            echo "option4 &nbsp;&nbsp;";echo '<input class="answers" type="text" value="'.$option4.'" readonly>' ;echo "&nbsp;&nbsp;&nbsp;&nbsp;";
                            echo "Correct answer &nbsp;&nbsp;";echo '<input class="answers" type="text" value="'.$correct_answer.'" readonly>' ;echo "<br><br>";
                            echo '<input type="file" name="image">';echo "<br><br>";
                            echo '<input class="btn btn-success" type="submit" id="submiquiztbtn" name="up_image" value="Upload image">';
                            echo '</form>'; 
                            
                            echo '<form action="" class="form-group" name="del" method="POST" >';
                            echo '<input type="hidden" name="question_no" value="'.$srno.'">';
                            echo '<input class="btn btn-danger" type="submit" id="submiquiztbtn" name="delimage" value="Delete image">';
                            echo '</form>';
                            echo "<hr>";
                            $c++;
                        
                        }
                    }
                        
                        
                    
                ?>
                    
                    
                    


                   

                   
    

</body>
</html>
