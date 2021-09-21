<?php
    require_once 'pdo.php';
    require_once 'boot.html';
    require_once 'dompdf/autoload.inc.php';
    
    session_start();
    unset($_SESSION['quiz_started']);

    
    
    
        if(isset($_POST["down_report"]))
            {
                $user_email = $_POST['email'];
                date_default_timezone_set("Asia/Kolkata");
                
                $date = date('His',time('His')+120);
                
                $html_code = '<link rel="stylesheet" href="./boot.html">';
                $html_code .= details();
                $_SESSION['file'] = $html_code;
                $_SESSION['rep_msg'] = "You will receive your report by tomorrow";
                $sql = "INSERT INTO cron_report (file,email,date) VALUES (:file, :email, :date)";
                
                $stmt = $pdo->prepare($sql);
                $stmt->execute(array(
                    ':file' => $html_code,
                    ':email' => $user_email,
                    ':date' => $date));

            
            header("Location:get_no_op_report.php");
            return;
            
        }
        // if(isset($_SESSION['wt_user_answers'])){
        //     foreach($_SESSION['wt_user_answers'] as $k=>$v){
        //         echo $k."=>".$v."<br>";
        //     }
        //     unset($_SESSION['wtq']);
        //     unset($_SESSION['wtc']);
            
        // }
            
    if(isset($_SESSION['wt_user_answers'])){
        

        $_SESSION['noopmsg'] = "Check your answer and Expected answer";
        $submitted_answers=array();
        
        foreach($_SESSION['wt_user_answers'] as $k=>$v){
            // if($k == 'submitnooption'){
            //     continue;
            // }
            $submitted_answers[$k]=$v;
            
        }
        
        ksort($submitted_answers);
        $stmt = $pdo->query('SELECT DISTINCT srno,question,answer,option1,option2,option3,option4,diagram FROM que_ans WHERE medium="'.$_SESSION['medium'].'" AND std="'.$_SESSION['std'].'" AND subject="'.$_SESSION['subject'].'" AND chapname="'.$_SESSION['chapname'].'" ORDER BY RAND()');
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $report=array();
        $report_index=1;
        foreach($rows as $row){
            if(($row['option1'] == NULL) && ($row['option2'] == NULL)){
                $srno = $row['srno'];
                $ca = trim($row['answer']);
                $ua = trim($submitted_answers[$srno]);
                $report[$report_index]="<h4>Question:<br>".$row['question']."</h4><br><h4>Your answer:</h4>".$ua."<br><h4>Expected answer:</h4>".$ca.".";
                $report_index++;
            }
            else {
                continue;
            }
             
                
        }
        $_SESSION['report']=$report;
        
        header("Location:get_no_op_report.php");
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
<h2 style="text-align:center;">Enter your email to receive Report</h2>

        <script>alert("Quiz submitted successfully!");</script>
        


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
                foreach($_SESSION['report'] as $k=>$v){
                    $output .= '
                    <tr>
                    <td>'. $n++ . '<br></td>
                    

                    
                    <td>'. $v . '<br></td>
                    </tr>';
                    
                }
                
                
                return $output;
        }
        ?>
        <?php
            if(isset($_SESSION['rep_msg'])){
                echo "<h2 style=\"color:steelblue\">". $_SESSION['rep_msg'] . "<h2>";
                unset($_SESSION['rep_msg']);
            }
        ?>
        <form action="" method="post">
    <label for="email">Enter your email</label>
                <input type="email" name="email" placeholder="Enter your email"> <br>
                <input claSS="btn btn-success" type="submit" value="send report" name="down_report">
    </form>
   


    

</body>
</html>