<?php
    require_once '../pdo.php';
    require_once '../boot.html';
    session_start();
    
    
    //unset($_SESSION['email']);
    if(isset($_POST['email']) && isset($_POST['password'])){
        $email=$_POST['email'];
        $pwd=$_POST['password'];
        
        if(($email == "admin") && ($pwd == "abc@1231")){
            $_SESSION['admin_logged_in']=TRUE;
            $_SESSION['adminemail']=$email;
            header("Location:admin_homepage.php");
            return;
        }
        else{
            $_SESSION['errmsg1']="<h2 style='text-align:center;color:red;'>Invalid username or password!</h2>";
            
            header("Location:./adminlogin.php");
            return;
        }
    }
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../static/login.css">
    
</head>
<body>
    <div class="sidenav">
        <div class="login-main-text">
           <h1>Administrator</h1> <br> <h3>Login Page</h3>
           <p>Login or create new account from here to access.</p>
        </div>
        
     </div>
     <div class="main">
        <div class="col-md-6 col-sm-12">
           <div class="login-form">
           <?php
    
                if(isset($_SESSION['errmsg1'])){
                    echo ($_SESSION['errmsg1']);
                    unset($_SESSION['errmsg1']);
                }
            ?>
            
              <form method="POST">
                 <div class="form-group">
                    <label>User name</label>
                    <input type="text" name="email" class="form-control" placeholder="User Name" required>
                 </div>
                 <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control" placeholder="Password" required>
                 </div>
                 <button type="submit" class="btn btn-success">Login</button>
                 <a href="../index.php" class="btn btn-warning">Go Back</a>
                 
              </form>
           </div>
        </div>
     </div>
</body>
</html>


