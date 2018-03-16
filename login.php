<!DOCTYPE html>
<html>
    <head>
        <title>Login</title>
        <link rel="stylesheet" href="styles.css">
        <?php
            if(isset($_POST['submit'])){
                $username =$_POST['username'];
                $pass=$_POST['password'];
                
                $conn =new mysqli("localhost","root","","project");
                if($conn->connect_error){
                    die("connection unsucessfull".$conn->connect_error);
                }
                $pass=md5($pass);
                $sql ="SELECT * FROM `users` WHERE `username`='$username';";
                $result=$conn->query($sql);
                if($result->num_rows > 0){
                    $row =$result->fetch_assoc();
                    if($row['password']===$pass){
                        session_start();
                        $_SESSION['username']=$row['username'];
                        $_SESSION['userId']=$row['userId'];
                        $_SESSION['email']=$row['email'];
                        header("location: timeline.php"); 
                        print "<script> alert('logged in') </script>";       
                    }else{
                        print "<script> alert('invalid password') </script>";
                    }

                }else{
                    print "<script> alert('User not found') </script>";
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
        <form action="" method="post" id="loginForm">
            <input type="text" name="username" id="username" placeholder="username"><br>
            <input type="password" name="password" id="password" placeholder="password"><br>
    
            <input type="submit" value="Submit" name="submit" class="submitbtn">
            <input type="reset" value="Reset" class="resetbtn">
        </form>
    </body>
</html>