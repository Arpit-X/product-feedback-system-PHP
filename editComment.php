<!DOCTYPE html>
<html>
    <head>
        <title>edit comment</title>
        <link rel="stylesheet" href="styles.css">
    </head>
    <?php
        session_start();
        $cid=$_GET['id'];
        $by=$_GET['by'];
        $pid=$_GET['pid'];
        if($by!==$_SESSION['username']){
            header("location: product.php?id=".$pid."");
        }
        if(isset($_POST['submit'])){
            $new=$_POST['edit'];
            $conn =new mysqli("localhost","root","","project");
            if($conn->connect_error){
                die("connection unsucessfull".$conn->connect_error);
            }
            $sql="UPDATE `comments` SET `comments`='$new' WHERE `by`='$by' AND `cid`='$cid' ;";
            if($conn->query($sql)){
                header("location: product.php?id=$pid");
            }
        }
    ?>
    <body>
        <form action="" method="post">
            <input type="text" name="edit" id="edit" placeholder="new comment">
            <input type="submit" value="Submit" name="submit">
        </form>
    </body>
</html>