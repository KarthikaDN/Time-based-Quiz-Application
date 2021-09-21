<?php
    require_once 'pdo.php';
    require_once 'boot.html';
    
    session_start();

    use PHPMailer\PHPMailer\PHPMailer; 
    use PHPMailer\PHPMailer\Exception;
    require_once('PHPMailer/src/PHPMailer.php');
    require_once('PHPMailer/src/Exception.php');
    require 'PHPMailer/src/SMTP.php';

    $stmt = $pdo->query("SELECT file,email,date FROM cron_report");
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    include('pdf.php');
    
    foreach($rows as $row){
        $pdf = new Pdf();
        date_default_timezone_set("Asia/Kolkata");
        $current_time = date('H:i:s');
        $dbtime = $row['date'];
        $repfile = $row['file'];
        $dbemail = $row['email'];
        echo "Current time: ".$current_time."------Mail time: ".$dbtime."<br>";
        if($current_time >= $dbtime){
            
            
            $file_name = md5(rand()) . '.pdf';
           
            
            $pdf->load_html($repfile);
            $pdf->render();
            $file = $pdf->output();
            file_put_contents($file_name, $file);
            
           
            $mail = new PHPMailer;
           
              $mail->isSMTP();                                     
                $mail->Host = 'smtp.gmail.com';  
                $mail->SMTPAuth = true;                              
                $mail->Username = '';//ENTER YOUR EMAIL HERE               
                $mail->Password = ''; // ENTER YOUR PASSWORD HERE                         
                $mail->SMTPSecure = 'tls';                            
                $mail->From = 'dnkcake@gmail.com';
                $mail->FromName = 'Smart World';
                $mail->addAddress($dbemail, 'User');
                $mail->WordWrap = 50;       
            $mail->IsHTML(true);       
            $mail->AddAttachment($file_name);       
            $mail->Subject = 'Quiz Report';   
            $mail->Body = 'PFA Report'; 
            
            if($mail->Send())       
            {
                echo "Mail sent to ". $dbemail."<br> ";
                $sql = "DELETE FROM cron_report WHERE email = :email AND date = :date";
                $stmt = $pdo->prepare($sql);
                $stmt->execute(array(':email' => $dbemail,
                                     ':date' => $dbtime
                                     ));
            }
            unlink($file_name);
            
        }
        
    }
    

?>