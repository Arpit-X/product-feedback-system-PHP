<!DOCTYPE html>
<html>
    <head>
        <title>signup</title>
        <link rel="stylesheet" href="styles.css">
        <?php
            if(isset($_POST['submit'])){
                $username =$_POST['username'];
                $pass=$_POST['password'];
                $conf=$_POST['conf'];
                $email=$_POST['email'];
                $conn =new mysqli("localhost","root","","project");
                if($conn->connect_error){
                    die("connection unsucessfull".$conn->connect_error);
                }
                if($pass===$conf && $pass){
                    $pass= md5($pass);
                    $sql= "INSERT INTO `users`(`username`, `password`, `email`) VALUES ('$username','$pass','$email');";
                    if($conn->query($sql)===true){
                        print "<script> alert('successfully logged in') </script>";
                        header("location: login.php");
                    }

                }
                else{
                    print "<script> alert('password dont match\n try agin') </script>";
                    header("location: signup.php");
                }
                
            }
        ?>
    </head>
    <body>
        <?php session_start(); 
            print "<nav>";
                print "<ul>";
                    print "<li><a href='timeline.php'>Timeline</a></li>";
                    if(!isset($_SESSION['username']))print '<li><a href="login.php">Login</a></li>';
                    if(isset($_SESSION['username']))print '<li><a href="logout.php">Logout</a></li>';
                    if(!isset($_SESSION['username']))print '<li><a href="signup.php">SignUp</a></li>';
                    if(isset($_SESSION['username']))print '<li><a href="logout.php">Logout</a></li>';
                print "</ul>";
            print "</nav>";
        ?>
        <form action="" method="post" id="signupForm">
            <input type="text" name="username" id="username" placeholder="username"><br>
            <input type="password" name="password" id="password" placeholder="password"><br>
            <input type="password" name="conf" id="conf" placeholder="retype password"><br>
            <input type="email" name="email" id="email" placeholder="email adress"><br>
            <input type="submit" value="Submit" name="submit" class="submitbtn">
            <input type="reset" value="Reset" class="resetbtn">
        </form>
    </body>
</html>