<?php
    session_start();
    include_once "config.php";
    $send_id = $_SESSION['unique_id'];
    $sql = mysqli_query($conn, "SELECT * FROM users WHERE NOT unique_id = {$send_id}");
    $output = "";

    if (mysqli_num_rows($sql) == 0) {
        $output .= "No users are available to chat now, try again later";
    } elseif (mysqli_num_rows($sql) > 0) {
        include "data.php";
    }

    echo $output;
?>