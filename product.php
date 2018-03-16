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
                    if(isset($_SESSION['username']))print '<li><a href="logout.php">Logout</a></li>';
                print "</ul>";
            print "</nav>";
        ?>
        <?php
            $pid=$_GET['id'];
            $conn =new mysqli("localhost","root","","project");
            if($conn->connect_error){
                die("connection unsucessfull".$conn->connect_error);
            }
            $sql ="SELECT * FROM `Products` WHERE `productId`='$pid';";
            $result=$conn->query($sql);
            if($result->num_rows > 0){
               $row=$result->fetch_assoc();
               print "<div class='product'>
                        <img src='".$row['image']."' alt=".$row['pname'].">
                        <h1>".$row['pname']."</h1>
                        <spna class='rating'>".$row['rating']."</span>
                        <p>".$row['pdesc']."</p>
                        <p>By ".$row['by']."</p>
                    </div> ";
                print "<div class='comments'>";    
                $query="SELECT * FROM `comments` WHERE  `pid`='$pid';";
                $res=$conn->query($query);
                if($res->num_rows > 0){
                    while($com=$res->fetch_assoc()){
                        print "
                        <div calss='comment'>
                            <p>".$com['comments']." <span> @".$com['by']."</span></p><a href='editComment.php?id=".$com['cid']."&by=".$com['by']."&pid=".$pid."'>Edit</a>    
                        </div>
                        ";
                        
                    }
                }
                print "</div>";    
            }
            if(isset($_SESSION['username']))
            {
                if(isset($_POST['subCom'])){
                    $comment=$_POST['comment'];
                    $rating=$_POST['rating']%5;
                    $by=$_SESSION['username'];
                   $sql2="INSERT INTO `comments`(`pid`, `comments`, `rating`,`by`) VALUES ('$pid','$comment','$rating','$by');";
                   if($conn->query($sql2)){
                       header("location:product.php?id=$pid");
                   } 
                }
                print '<form action="" method="post" id="addcomment">
                    <input type="text" name="comment" id="comment" placeholder="enter  comment">
                    <label for="rating">Rating : </label>
                    <input type="number" name="rating" id="rating">
                    <input type="submit" value="Add comment" name="subCom">
                </form>';
            }
        ?>  
          
    </body>
</html>