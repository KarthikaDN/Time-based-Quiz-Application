<?php
    require_once 'pdo.php';
    require_once 'boot.html';
    
    session_start();
    
    if(!isset($_SESSION['quiz_started'])){
        
        header("Location:index.php");
        return;
    }

    

    if(isset($_POST['quetype'])){
        $_SESSION['quetype'] = $_POST['quetype'];
        header("Location:quiz_startquiz.php");
        return;
    }
    
?>

<body class="container" onload="countdownTimeStart()">
<p id="demo" style="text-align:right;font-size:30px;position:fixed;top:10px;right:50px;background-color:steelblue;color:white;border-radius:10px;"></p><br><br><br><br>
<h3><?php echo $_SESSION['quetype'];?></h3><hr><br><br><br>

<?php
    if(isset($_SESSION['msg'])){
        echo "<h3 style=\"color:red;\">".$_SESSION['msg']."</h3>";
        unset($_SESSION['msg']);
    }
?>
        
        <?php 
            $stmt = $pdo->query('SELECT DISTINCT srno,question,answer,option1,option2,option3,option4,diagram FROM que_ans WHERE medium="'.$_SESSION['medium'].'" AND std="'.$_SESSION['std'].'" AND subject="'.$_SESSION['subject'].'" AND chapname="'.$_SESSION['chapname'].'" ORDER BY RAND()');
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if(count($rows) == 0){
                echo "<h1>Sorry! There are no questions!</h1><br><h2>Please choose different type of question.</h2>";
                return;
            }
            
            
            if($_SESSION['quetype'] == "Written test"){
               
                if(!isset($_SESSION['wtq'])){
                    //$wt_user_answers=array();
                    $_SESSION['wtq'] = true;
                    $wtq = array();
                    $i=0;
                    foreach($rows as $row){
                        $wtq[$i]=$row;
                        $i++;
                    }
                    // $_SESSION['wtq']=$rows;
                    $_SESSION['wtc']=0;
                }
                if(isset($_POST['wtsub'])){
                    $_SESSION['wtc']++;
                    foreach($_POST as $k=>$v){
                        if($k == "wtsub"){
                            continue;
                        }
                        //$wt_user_answers[$k]=$v;
                        $_SESSION['wt_user_answers'][$k] = $v;
                    }
                    header("Location:quiz_startquiz.php");
                    return;
                }
                
                
                    //foreach($rows as $row){
                        if(!empty($wtq[$_SESSION['wtc']])){
                            $question = $wtq[$_SESSION['wtc']];

                            if(($question['option1'] == NULL) && ($question['option2'] == NULL) ){
                                $srno = $question['srno'];
                                $q=$question['question'];
                                $diagram = $question['diagram'];
                                $correct_answer = $question['answer'];
                                echo '<form method="POST">';
                                echo "<h3>". $_SESSION['wtc'].") ".$q; echo "</h3>";
                                echo '<img src="./admin/pictures/'.$diagram.'" alt="image" style="width:228px;height:228px;">';echo "<br><br>";
                                echo '<textarea class="answers" name="'.$srno.'" id="'.$srno.'" rows="5" cols="100" ></textarea>';echo '<br>'; 
                                echo '<button id="'.$srno.'btn" type="submit" name="wtsub" class="btn btn-primary">Next</button>';
                                echo '</form>';
    
                                
                                
                                
                            }
                        }
                        else{
                            
                            header("Location:get_no_op_report.php");
                            return;
                        }
                        
                        
                        
                    //}
                
       
            }
        
        ?>
        <br>
        <?php
        if($_SESSION['quetype'] == "Oral test"){
        //              unset($_SESSION['wtq1']);
        //                     unset($_SESSION['wtc1']);
        // unset($_SESSION['wt_user_answers1']);
            if(!isset($_SESSION['wtq1'])){
                //$wt_user_answers=array();
                unset($_SESSION['wt_user_answers1']);
                $_SESSION['wtq1']=$rows;
                $_SESSION['wtc1']=0;
            }
            if(isset($_POST['wtsub'])){
                $_SESSION['wtc1']++;
                foreach($_POST as $k=>$v){
                    if($k == "wtsub"){
                        continue;
                    }
                    //$wt_user_answers[$k]=$v;
                    $_SESSION['wt_user_answers1'][$k] = $v;
                }
                header("Location:quiz_startquiz.php");
                
            }
                    //foreach($rows as $row){
                        if(!empty($_SESSION['wtq1'][$_SESSION['wtc1']])){
                            $question = $_SESSION['wtq1'][$_SESSION['wtc1']];

                            if(($question['option1'] == NULL) && ($question['option2'] == NULL) ){
                                $srno = $question['srno'];
                                $q=$question['question'];
                                $diagram = $question['diagram'];
                                $correct_answer = $question['answer'];
                                echo '<form method="POST">';
                                echo "<h3>". $_SESSION['wtc1'].") ".$q; echo "</h3>";
                                echo '<img src="./admin/pictures/'.$diagram.'" alt="image" style="width:228px;height:228px;">';echo "<br><br>";
                                echo '<textarea class="answers" name="'.$srno.'" id="'.$srno.'" rows="5" cols="100" ></textarea>';echo '<br>'; 
                                
                                echo '<button id="'.$srno.'btn" type="button" class="btn btn-primary">Start speaking</button><br><br>';
                                echo '<button id="'.$srno.'btn" type="submit" name="wtsub" class="btn btn-danger">Next question</button>';
                                echo '<h5 id="'.$srno.'instructions">Press the above button and start speaking</h5>';
                                echo '</form>';
    
                                
                                
                                
                            }
                        }
                        else{
                            
                            header("Location:get_no_op_report.php");
                            return;
                        }
                        
                        
                    }
                    // if($c == 1){
                    //     echo "<h1>Sorry! There are no Oral test questions in this chapter!</h1><br><h2>Please choose different type of question.</h2>";
                    //     return;
                    // }
        ?>
        <br>
        <br>
        




        <?php
        
        


        
                        
        
            if($_SESSION['quetype'] == "MCQ"){
                
            ?>        
                        <form action="get_op_report.php" class="form-group" name="qform" method="POST" id="">
                <?php
                    $c=1;
                    foreach($rows as $row){
                        if(($row['option1'] == NULL) && ($row['option2'] == NULL) ){
                            continue;
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
                            echo "<h3>". $c.") ".$q; echo "</h3>";
                            echo '<img src="./admin/pictures/'.$diagram.'" alt="image" style="width:228px;height:228px;">';echo "<br><br>";
                            echo '<input class="answers" type="radio" name="'.$srno.'" value="'.$option1.'" >' ;echo "&nbsp; &nbsp;<span class='options'>". $option1."</span><br>"; 
                            echo '<input class="answers" type="radio" name="'.$srno.'" value="'.$option2.'">' ;echo "&nbsp; &nbsp;<span class='options'>". $option2."</span><br>";
                            echo '<input class="answers" type="radio" name="'.$srno.'" value="'.$option3.'">' ;echo "&nbsp; &nbsp;<span class='options'>". $option3."</span><br>";
                            echo '<input class="answers" type="radio" name="'.$srno.'" value="'.$option4.'">' ;echo "&nbsp; &nbsp;<span class='options'>". $option4."</span><br>";
                        
                            $c++;
                        }
                        
                        
                    }
                    // if($c == 1){
                    //     echo "<h1>Sorry! There are no MCQ questions in this chapter!</h1><br><h2>Please choose different type of question.</h2>";
                    //     return;
                    // }
                ?>
                    <br>
                    <br>
                    <input class="btn btn-success" type="submit" id="submiquiztbtn" name="submitoption" value="submit">
                    </form>


                    <?php
                    }
            
                
                ?>

                    <!-- ----------------------TIMER------------------------ -->
    <script>

        

function countdownTimeStart(){
    var display_demo = document.getElementById("demo");
    var countDownDate1 = new Date();
    var countDownDate = new Date(countDownDate1);
    <?php
        
        if($c-1 == 0){
           
            $c=100000;
            echo "<script>display_demo.style.display='none'";
        }
    ?>
    countDownDate.setMinutes(countDownDate1.getMinutes() + <?php echo $c-1 ?>);

    
    var x = setInterval(function() {

        
        var now = new Date().getTime();
        
        
        var distance = countDownDate - now;
        
        
        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60)) / 1000);
        
       
        document.getElementById("demo").innerHTML = hours + "h "
        + minutes + "m " + seconds + "s remaining";
        
       
        if (distance < 0) {
            clearInterval(x);
            alert("Timeout! Quiz will be submitted atomatically.\nClick OK to continue");
            document.getElementById("submiquiztbtn").click();
        }
    }, 1000);
    }
</script>


<script>
<?php
    $stmt = $pdo->query('SELECT DISTINCT srno,option1,option2 FROM que_ans WHERE medium="'.$_SESSION['medium'].'" AND std="'.$_SESSION['std'].'" AND subject="'.$_SESSION['subject'].'" AND chapname="'.$_SESSION['chapname'].'" ORDER BY RAND()');
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach($rows as $row){
        if(($row['option1'] == NULL) && ($row['option2'] == NULL)){
            $srno = $row['srno'];
        
        
?>
    document.getElementById("<?php echo $srno.'btn'?>").onclick = function(){
        var SpeechRecognition = window.webkitSpeechRecognition;

        var recognition = new SpeechRecognition();

        var Textbox = $('#<?php echo $srno ?>');
        var instructions = $('#<?php echo $srno."instructions"?>');

        var Content = '';

        recognition.continuous = true;

        recognition.onresult = function(event) {

            var current = event.resultIndex;

            var transcript = event.results[current][0].transcript;

            Content += transcript;
            Textbox.val(Content);
            
        };

        recognition.onstart = function() { 
            instructions.text('Voice recognition is ON.');
        }

        recognition.onspeechend = function() {
            instructions.text('No activity.');
        }

        recognition.onerror = function(event) {
            if(event.error == 'no-speech') {
            instructions.text('Try again.');  
            }
        }

        $('#<?php echo $srno."btn"?>').on('click', function(e) {
            if (Content.length) {
            Content += ' ';
            }
            recognition.start();
        });

        Textbox.on('input', function() {
            Content = $(this).val();
        })
    }

    <?php
        }
        else{
            continue;
        }
    }
    ?>

    
</script>


</body>
</html>
