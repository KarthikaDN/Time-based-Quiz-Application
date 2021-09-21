<?php
    require_once '../pdo.php';
    require_once '../boot.html';
    require_once 'navbar.php';
    session_start();
    if(!isset($_SESSION['admin_logged_in'])){
        header("location:./adminlogin.php");
        
    }
    unset($_SESSION['update_started']);
    if(isset($_POST['quetype'])){
        $_SESSION['quetype'] = $_POST['quetype'];
        header("Location:update_start.php");
        return;
    }

    if(isset($_POST['update_op'])){

        $updated_values=array();
        foreach($_POST as $k=>$v){
            if($k=="update_op"){
                continue;
            }
            $updated_values[$k]=$v;
            //echo $k."=>".$v."<br>";
        }
        //try{
            $sql = "UPDATE que_ans SET question=:q, option1=:o1, option2=:o2, option3=:o3,option4=:o4,answer=:ca WHERE srno=:qno";
            $stmt = $pdo->prepare($sql);
            $y=0;
            foreach($updated_values as $k=>$v){
                if($k%10 == 0){
                    
                    $mcqq=$v;
                    $mcqsrno = $k/10;
                    continue;
                }
                if($k%10 == 1){
                    
                    $mcqo1=$v;
                    continue;
                }
                if($k%10 == 2){
                    
                    $mcqo2=$v;
                    continue;
                }
                if($k%10 == 3){
                    
                    $mcqo3=$v;
                    continue;
                }
                if($k%10 == 4){
                    
                    $mcqo4=$v;
                    continue;
                }
                if($k%10 == 5){
                    
                    $mcqca=$v;

                    $stmt->execute(array(
                                ':q' =>$mcqq, 
                                ':o1' =>$mcqo1, 
                                ':o2' =>$mcqo2,
                                ':o3' =>$mcqo3,
                                ':o4' =>$mcqo4,
                                ':ca' =>$mcqca,
                                ':qno' => $mcqsrno
                            
                            ));
                            
                    continue;
                }
            }
            $_SESSION['up_smsg'] = "Questions Updated successfully!";
            header("Location:update_start.php");
            return;
        }

        if(isset($_POST['update_no_op'])){
            $updated_values=array();
            foreach($_POST as $k=>$v){
                if($k=="update_no_op"){
                    continue;
                }
                $updated_values[$k]=$v;
                //echo $k."=>".$v."<br>";
            }
    
            $sql = "UPDATE que_ans SET question=:q,answer=:ca WHERE srno=:qno";
                $stmt = $pdo->prepare($sql);
                $y=0;
                foreach($updated_values as $k=>$v){
                    if($k%10 == 0){
                        
                        $atfq=$v;
                        $atfsrno = $k/10;
                        continue;
                    }
                    if($k%10 == 1){
                        $atfca=$v;
    
                        $stmt->execute(array(
                                    ':q' =>$atfq, 
                                    ':ca' =>$atfca,
                                    ':qno' => $atfsrno
                                
                                ));
                                
                        continue;
                        
                    }
                    
                }
                $_SESSION['up_smsg'] = "Questions Updated successfully!";
            //}
            // catch(Exception e){
            //     $_SESSION['up_errmsg'] = "Couldn't update !";
            // }
            header("Location:update_start.php");
            return;
        }
    
?>
<html>
<body class="container">
<?php
    if(isset($_SESSION['up_smsg'])){
        echo "<h2 style=\"color:steelblue;\">".$_SESSION['up_smsg']."</h2>";
        unset($_SESSION['up_smsg']);
    }
?>
<h3><?php echo $_SESSION['quetype'];?></h3><hr><br><br><br>

<?php
    if(isset($_SESSION['msg'])){
        echo "<h3 style=\"color:red;\">".$_SESSION['msg']."</h3>";
        unset($_SESSION['msg']);
    }
?>
        
        <?php 
            $stmt = $pdo->query('SELECT DISTINCT srno,question,answer,option1,option2,option3,option4,diagram FROM que_ans WHERE medium="'.$_SESSION['medium'].'" AND std="'.$_SESSION['std'].'" AND subject="'.$_SESSION['subject'].'" AND chapname="'.$_SESSION['chapname'].'" AND quetype="'.$_SESSION['quetype'].'" ORDER BY RAND()');
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if(count($rows) == 0){
                echo "<h1>Sorry! There are no questions!</h1><br><h2>Please choose different type of question.</h2>";
                return;
            }
            
            
        
               
                        
                
                    $c=1;
                    foreach($rows as $row){
                        if(($row['option1'] == NULL) || ($row['option2'] == NULL)){
                            $namec=0;
                            $srno = $row['srno'];
                            $q=$row['question'];
                            
                            echo '<form action="" class="form-group" name="qform" method="POST" id="">';
                            $correct_answer = $row['answer'];
                            echo "<h2>".$c.")Question </h2>"; echo '<h4><textarea rows="3" cols="50" class="answers" type="text" name="'.$srno.$namec++.'" value="'.$q.'" >'.$q.'</textarea></h4>' ;echo "<br><br>";
                            echo "Answer &nbsp;&nbsp;&nbsp;";echo '<textarea rows="6" cols="50" class="answers" type="text" name="'.$srno.$namec++.'" value="'.$correct_answer.'" >'.$correct_answer.'</textarea>' ;echo "<br><br>";
                            echo '<input class="btn btn-success" type="submit" id="submiquiztbtn" name="update_no_op" value="Update">';
                            echo '</form>';
                            echo '<hr>';
                            $c++;
                        }
                        else{
                            $namec=0;
                            $srno = $row['srno'];
                            $q=$row['question'];
                            $option1 = $row['option1'];
                            $option2 = $row['option2'];
                            $option3 = $row['option3'];
                            $option4 = $row['option4'];
                            $correct_answer = $row['answer'];
                            $diagram = $row['diagram'];

                            echo '<form action="" class="form-group" name="qform" method="POST" id="">';
                            echo "<h2>".$c.")Question </h2>"; echo '<h4><textarea rows="3" cols="50" class="answers" type="text" name="'.$srno.$namec++.'" value="'.$q.'" >'.$q.'</textarea></h4>' ;echo "<br><br>";
                            echo "option1 &nbsp;&nbsp;&nbsp;";echo '<input class="answers" type="text" name="'.$srno .$namec++.'" value="'.$option1.'" >' ;echo "<br><br>"; 
                            echo "option2 &nbsp;&nbsp;";echo '<input class="answers" type="text" name="'.$srno .$namec++.'" value="'.$option2.'">' ;echo "<br><br>"; 
                            echo "option3 &nbsp;&nbsp;";echo '<input class="answers" type="text" name="'.$srno .$namec++.'" value="'.$option3.'">' ;echo "<br><br>"; 
                            echo "option4 &nbsp;&nbsp;";echo '<input class="answers" type="text" name="'.$srno .$namec++.'" value="'.$option4.'">' ;echo "&nbsp;&nbsp;&nbsp;&nbsp;";
                            echo "Correct answer &nbsp;&nbsp;";echo '<input class="answers" type="text" name="'.$srno .$namec++.'" value="'.$correct_answer.'">' ;echo "<br><br>"; 
                            echo '<input class="btn btn-success" type="submit" id="submiquiztbtn" name="update_op" value="Update">';
                            echo '</form>';
                            echo '<hr>';
                            
                            $c++;
                        }
                        
                        
                    }
                ?>
                    
                    
                    


                   

                   
    

</body>
</html>
