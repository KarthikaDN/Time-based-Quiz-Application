<?php
    require_once '../pdo.php';
    require_once '../boot.html';
    require_once './navbar.php';
    session_start();
    if(!isset($_SESSION['admin_logged_in'])){
        header("location:./adminlogin.php");
        
    }
    unset($_SESSION['delete_started']);
    if(isset($_POST['quetype'])){
        $_SESSION['quetype1'] = $_POST['quetype'];
        header("Location:delete_start.php");
        return;
    }

    if(isset($_POST['delete'])){
        foreach($_POST as $k=>$v){
            if($k == "delete"){
                continue;
            }
            $question_to_be_deleted = $k;
           
        }
        $sql = "DELETE FROM que_ans WHERE srno = :qno";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(':qno' => $question_to_be_deleted));
        $_SESSION['delmsg'] = "Successfully deleted";
        header("Location:delete_start.php");
        return;
        
    }

    
    
?>
<html>
<body class="container">
<?php
    
?>
<h3><?php echo $_SESSION['quetype1'];?></h3><hr><br><br><br>
        <?php
            if(isset($_SESSION['delmsg'])){
                echo "<h2 style=\"color:steelblue;\">".$_SESSION['delmsg']."</h2>";
                unset($_SESSION['delmsg']);
            }
        ?>

        <?php 
            $stmt = $pdo->query('SELECT DISTINCT srno,question,answer,option1,option2,option3,option4,diagram FROM que_ans WHERE medium="'.$_SESSION['medium1'].'" AND std="'.$_SESSION['std1'].'" AND subject="'.$_SESSION['subject1'].'" AND chapname="'.$_SESSION['chapname1'].'" AND quetype="'.$_SESSION['quetype1'].'" ORDER BY RAND()');
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
                            echo '<form action="" class="form-group" name="qform" method="POST" id="">';
                            echo "<h2>".$c.")Question </h2>"; echo '<h4><textarea rows="3" cols="50" class="answers" type="text" name="'.$srno.'" value="'.$q.'" >'.$q.'</textarea></h4>' ;echo "<br><br>";
                            echo "Answer &nbsp;&nbsp;&nbsp;";echo '<textarea rows="6" cols="50" class="answers" type="text" value="'.$correct_answer.'" >'.$correct_answer.'</textarea>' ;echo "<br><br>";
                            echo ' <input class="btn btn-danger" type="submit" id="submiquiztbtn" name="delete" value="DELETE">';
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
                                echo '<form action="" class="form-group" name="qform" method="POST" id="">';
                                echo "<h2>".$c.")Question </h2>"; echo '<h4><textarea rows="3" cols="50" class="answers" type="text" name="'.$srno.'" value="'.$q.'" >'.$q.'</textarea></h4>' ;echo "<br><br>";
                                echo "option1 &nbsp;&nbsp;&nbsp;";echo '<input class="answers" type="text" value="'.$option1.'" >' ;echo "<br><br>"; 
                                echo "option2 &nbsp;&nbsp;";echo '<input class="answers" type="text" value="'.$option2.'">' ;echo "<br><br>"; 
                                echo "option3 &nbsp;&nbsp;";echo '<input class="answers" type="text" value="'.$option3.'">' ;echo "<br><br>"; 
                                echo "option4 &nbsp;&nbsp;";echo '<input class="answers" type="text" value="'.$option4.'">' ;echo "&nbsp;&nbsp;&nbsp;&nbsp;";
                                echo "Correct answer &nbsp;&nbsp;";echo '<input class="answers" type="text" value="'.$correct_answer.'">' ;echo "<br><br>";
                                echo '<input class="btn btn-danger" type="submit" id="submiquiztbtn" name="delete" value="DELETE">';
                                echo '</form>'; 
                                echo "<hr>";
                                $c++;
                        
                        }
                    }
                        
                        
                    
                ?>
                    
                    
                    


                   

                   
    

</body>
</html>
