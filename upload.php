<!DOCTYPE html>
<html>
    <head>
        <title>signup</title>
        <link rel="stylesheet" href="styles.css">
        <?php
            session_start();
            if(!isset($_SESSION['userId'])) header("location: login.php");
            if(isset($_POST['submit'])){
                $pname =$_POST['pname'];
                $desc=$_POST['desc'];
                $rating=$_POST['rating']%5;
                $image="";
                $by=$_SESSION['username'];
                $conn =new mysqli("localhost","root","","project");
                if($conn->connect_error){
                    die("connection unsucessfull".$conn->connect_error);
                }
                $baseDir="uploads/";
                $targetFile=$baseDir.basename($_FILES['image']['name']);
                $type=strtolower(pathinfo($targetFile,PATHINFO_EXTENSION));
                if($type!="jpg" && $type!="png"){
                    print "<script> alert('invalid file type') </script>";
                }
                elseif(file_exists($targetFile)){
                    print "<script> alert('file already exists') </script>";
                }else{
                    if(move_uploaded_file($_FILES['image']['tmp_name'],$targetFile)){
                        $image=$targetFile;

                    }else{
                        print "<script> alert('Error uploading the image') </script>";
                    }

                }
                $sql="INSERT INTO `Products`(`pname`, `pdesc`, `rating`, `image`, `by`) VALUES ('$pname','$desc','$rating','$image','$by');";
                if($image && $conn->query($sql)){
                    header("location: timeline.php");
                }
                
            }
        ?>
    </head>
    <body>
        <?php 
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
        <form action="" method="post" id="uploadForm" enctype="multipart/form-data"><br>
            <input type="text" name="pname" id="pname" placeholder="Product Name"><br>
            <textarea name="desc" id="desc" cols="30" rows="10" placeholder="Description"></textarea><br>
            <input type="number" name="rating" id="rating" placeholder="rating"><br>
            <input type="file" name="image" id="image"><br>
            <input type="submit" value="Submit" name="submit" class="submitbtn">
            <input type="reset" value="Reset" class="resetbtn">
        </form>
    </body>
</html>