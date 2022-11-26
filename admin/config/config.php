<?php
    $conn = mysqli_connect("localhost","root","","news_site");
    if($err = mysqli_connect_error()){
        die($err);
    }
?>