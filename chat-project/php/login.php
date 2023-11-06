<?php
    session_start();
    include_once "config.php";
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    if(!empty($email) && !empty($password)) {

        $query = "SELECT * FROM users WHERE email = '{$email}'";
        $result = mysqli_query($conn, $query);

        if ($result) {
            $user = mysqli_fetch_assoc($result);
        
            if ($user) {
                // Verify the password using password_verify
                $stored_hashed_password = $user['password'];
        
                if (password_verify($password, $stored_hashed_password)) {
                    $status = "Online";
                    $sql2 = mysqli_query($conn, "UPDATE users SET status = '{$status}' WHERE unique_id = {$user['unique_id']}");
                    if ($sql2) {
                        $_SESSION['unique_id'] = $user['unique_id'];
                        echo "success";
                    }
                } else {
                    echo "Incorrect login details (password or email)";
                }
            }
        } else {
            echo "Incorrect login details (password or email)";
        }

    } else {
        echo "All inputs are required";
    }
?>