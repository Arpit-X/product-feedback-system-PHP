<!DOCTYPE html>
<html>
    <head>
        <title>Login</title>
        <link rel="stylesheet" href="styles.css">
    </head>
    <body>
        <?php session_start(); 
            print "<nav>";
                print "<ul>";
                    print "<li><a href='timeline.php'>Timeline</a></li>";
                    if(!isset($_SESSION['username']))print '<li><a href="login.php">Login</a></li>';
                    if(isset($_SESSION['username']))print '<li><a href="logout.php">Logout</a></li>';
                    if(!isset($_SESSION['username']))print '<li><a href="signup.php">SignUp</a></li>';
                    if(isset($_SESSION['username']))print '<li><a href="upload.php">Upload</a></li>';
                print "</ul>";
            print "</nav>";
        ?>
        <?php
            $conn =new mysqli("localhost","root","","project");
            if($conn->connect_error){
                die("connection unsucessfull".$conn->connect_error);
            }
            $sql ="SELECT * FROM `Products` WHERE 1;";
            $result=$conn->query($sql);
            if($result->num_rows > 0){
                print "<div class='products'>";
                while($row =$result->fetch_assoc() ){
                    $avgrate=$row['rating'];
                    $rq="SELECT AVG(`rating`) FROM `comments` WHERE `pid`='".$row['productId']."';";
                    $res=$conn->query($rq);
                    if($res->num_rows > 0){
                        $val=$res->fetch_assoc();
                        $avgrate=(int)$val['AVG(`rating`)'];
                    }
                    print "<div class='product'>
                        <img src='".$row['image']."' alt='".$row['pname']."'>
                        <div>
                        <h2><a href='product.php?id=".$row['productId']."'>".$row['pname']."</a></h2>
                        <span class='rating'>".$avgrate."</span>
                        <p>".$row['pdesc']."</p>
                        <p> By ".$row['by']."</p>
                        </div>
                        </div><br>";
                }
                print "</div>";
            }
        ?>  
          
    </body>
</html>