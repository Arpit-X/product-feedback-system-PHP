<?php
    session_start();
    session_destroy();
    header("location: timeline.php");
?>