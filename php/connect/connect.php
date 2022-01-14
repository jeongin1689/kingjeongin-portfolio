<?php
    $host = "localhost";
    $user = "kingjeongin";
    $pass = "Ks13578823!!";
    $db = "kingjeongin";
    $connect = new mysqli($host, $user, $pass, $db);
    $connect -> set_charset("utf8");

    if( mysqli_connect_errno() ){
        echo "DATABASE connect False";
    }else {
        //echo "DATABASE connect True";
    }
?>