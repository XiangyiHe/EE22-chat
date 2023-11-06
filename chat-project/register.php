<?php
    session_start();
    if (isset($_SESSION['unique_id'])) {
        header("location: users.php");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Real time EE2E chat</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</head>

<body>
    <div class="wrapper">
        <section class="form signup">
            <h3 id="login-heading">Welcome to Real time EE2E Chat</h3>
            <form id="register-form" enctype="multipart/form-data " autocomplete="off">
                <div id="error-message" class="error"></div>
                <div class="mb-3">
                    <label for="user-name" class="form-label">Username</label>
                    <input type="text" name="uname" placeholder="Username" class="form-control" id="user-name" required>
                </div>
                <div class="mb-3">
                    <label for="register-email" class="form-label">Email address</label>
                    <input type="email" name="email" placeholder="Enter your email" class="form-control" id="register-email" required>
                </div>

                <div class="mb-3">
                    <label for="register-password" class="form-label">Password</label>
                    <input type="password" name="password" placeholder="Enter your password" class="form-control" id="register-password" required>
                    <i class="fas fa-eye show-password" id="show-password-register1"></i>
                </div>
                <div class="mb-3">
                    <label for="register-password-confirm" class="form-label">Confirmed your Password</label>
                    <input type="password" name="passwordConfirm" placeholder="Confirm your password" class="form-control" id="register-password-confirm" required>
                    <i class="fas fa-eye show-password" id="show-password-register2"></i>
                </div>
                <div class="mb-3">
                    <label for="register-pfp" class="form-label">Select profile picture</label>
                    <input type="file" name="image" class="form-control" id="register-pfp" required>
                </div>

                <button type="submit" id="register-submit" class="btn btn-primary form-label form-control">Submit to Register</button>
            </form>
            <div class="switch-register-login">Already have an account? <a href="login.php">Login Now</a></div>
        </section>
    </div>
    <script src="javascript/password-display.js"></script>
    <script src="javascript/signup.js"></script>
</body>
</html>