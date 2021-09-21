<?php
    require_once 'pdo.php';
    require_once 'boot.html';
    session_start();
    unset($_SESSION['quiz_started']);
    use PHPMailer\PHPMailer\PHPMailer; 
use PHPMailer\PHPMailer\Exception;
 require_once('PHPMailer/src/PHPMailer.php');
  require_once('PHPMailer/src/Exception.php');
require 'PHPMailer/src/SMTP.php';


    if(isset($_POST["down_report"])){
        $user_email = $_POST['email'];
                date_default_timezone_set("Asia/Kolkata");
                
                $date = date('His',time('His')+120);
                
                $html_code = '<link rel="stylesheet" href="./boot.html">';
                $html_code .= details();
                $_SESSION['file'] = $html_code;
                $_SESSION['rep_msg1'] = "You will receive your report by tomorrow";
                $sql = "INSERT INTO cron_report (file,email,date) VALUES (:file, :email, :date)";
                
                $stmt = $pdo->prepare($sql);
                $stmt->execute(array(
                    ':file' => $html_code,
                    ':email' => $user_email,
                    ':date' => $date));

            
            header("Location:get_op_report.php");
            return;
    }

    if(isset($_POST['submitoption'])){
        
        $submitted_answers=array();
        
        foreach($_POST as $k=>$v){
            if($k == 'submitoption'){
                continue;
            }
            $submitted_answers[$k]=$v;
            
        }
        ksort($submitted_answers);

        
        $total_questions=0;
        $attempted_questions=0;
        $not_attempted=0;
        $correct_answers=0;
        $wrong_answers=0;
        $result=0;
        $result_msg = array();
        $result_msg_index=1;

        $stmt = $pdo->query('SELECT DISTINCT srno,question,answer,option1,option2,option3,option4,diagram FROM que_ans WHERE medium="'.$_SESSION['medium'].'" AND std="'.$_SESSION['std'].'" AND subject="'.$_SESSION['subject'].'" AND chapname="'.$_SESSION['chapname'].'" ORDER BY RAND()');
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $ind=1;
        $qno=1;
        foreach($rows as $row){
            if(($row['option1'] == NULL) && ($row['option2'] == NULL)){
                continue;
            }
            $total_questions++;
            $srno = $row['srno'];
            if(isset($submitted_answers[$srno])){
                $attempted_questions++;
                $ca = trim($row['answer']);
                $ua = trim($submitted_answers[$srno]);
                if(strtolower($ca) == strtolower($ua)){
                    
                    $correct_answers++;
                    $result_msg[$result_msg_index]="<h4>Question:<br>".$row['question']."</h4> Expected answer: ". $row['answer'] . "<br> Your answer: ". $submitted_answers[$srno];
                    
                    $result++;
                }
                else{
                    
                    $wrong_answers++;
                    $result_msg[$result_msg_index]="<h4>Question:<br>".$row['question']."</h4> Expected answer: ". $row['answer'] . "<br> Your answer: ". $submitted_answers[$srno];
                     
                }
            }
            else{
                $not_attempted++;
                $result_msg[$result_msg_index]="<h4>Question:<br>".$row['question']."</h4> Expected answer: ". $row['answer'] . "<br> Your answer: ". $submitted_answers[$srno];
                
                
            }
            //$ind++;
            $qno++;
            //$position++;
            $result_msg_index++;

        }
        $_SESSION['total_questions1']=$total_questions;
        $_SESSION['attempted_questions1']=$attempted_questions;
        $_SESSION['not_attempted1']=$not_attempted;
        $_SESSION['correct_answers1']=$correct_answers;
        $_SESSION['wrong_answers1']=$wrong_answers;
        $_SESSION['total_marks1']=$result;
        $_SESSION['result_msg1']=$result_msg;
        header("Location:get_op_report.php");
        return;
        
        
    }
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Result</title>
</head>
<body class="container">
<h2 style="text-align:center;">Enter your email to receive Report</h2>


<script>alert("Quiz submitted successfully");</script>
    
        <?php
        function details(){
            
            $output = '
            <div class="table-responsive">
             <table class="table table-striped table-bordered" border="5">
              <tr>
               <th>sr.no</th>
               <th>Reviews</th>
               
              </tr>
            ';
        
        
            
            $n=1;
                foreach($_SESSION['result_msg1'] as $k=>$v){
                    $output .= '
                    <tr>
                    <td>'. $n++ . '<br></td>
                    

                    
                    <td>'. $v . '<br></td>
                    </tr>';
                    
                }
                $output .= '
                        </table>
                            </div>
                            ';
                $output.='<h4>Total questions:'. $_SESSION['total_questions1'].'</h4>
                <h4>No.of attempted questions :'. $_SESSION['attempted_questions1'].'</h4>
                <h4>No.of not attempted questions:'. $_SESSION['not_attempted1'].'</h4>
                <h4>Correct answers:'. $_SESSION['correct_answers1'].'</h4>
                <h4>Wrong answers:'. $_SESSION['wrong_answers1'].'</h4>
            
                <h2 style="text-align:center;">Your Total score:'.$_SESSION['total_marks1'].'</h2>
                <h2 style="text-align:center;">Percentage:'.($_SESSION['correct_answers1']/$_SESSION['total_questions1'])*100 .'</h2>
                ';
                
                return $output;
        }
        ?>

        
        
    
    
    

    
        <?php
            if(isset($_SESSION['rep_msg1'])){
                echo "<h2 style=\"color:steelblue\">". $_SESSION['rep_msg1'] . "<h2>";
                unset($_SESSION['rep_msg1']);
            }
        ?>


    <form action="" method="post">
    <label for="email">Enter your email</label>
                <input type="email" name="email" placeholder="Enter your email"> <br>
                <input claSS="btn btn-success" type="submit" value="send report" name="down_report">
    </form>

   
</body>
</html>