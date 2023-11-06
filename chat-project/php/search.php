<?php
    session_start();
    include_once "config.php";
    $send_id = $_SESSION['unique_id'];
    $searchWord = mysqli_real_escape_string($conn, $_POST['searchWord']);

    $output = "";
    $sql = mysqli_query($conn, "SELECT * FROM users WHERE NOT unique_id = {$send_id} AND (uname LIKE '%{$searchWord}%')");
    if(mysqli_num_rows($sql) > 0) {
        include "data.php";
    } else {
        $output .= "No user found, please try another username";
    }

    echo $output;

?>