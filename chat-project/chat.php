<?php
    session_start();
    if (!isset($_SESSION['unique_id'])) {
        header("location: login.php");
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
        <section class="chats">
            <header id="chat-header" class="user-info">
                <?php
                    include_once "php/config.php";
                    $user_id = mysqli_real_escape_string($conn, $_GET['user_id']);
                    $sql = mysqli_query($conn, "SELECT * FROM users WHERE unique_id = {$user_id}");
                    if (mysqli_num_rows($sql) > 0) {
                        $row = mysqli_fetch_assoc($sql);

                    } 
                ?>
                <a href="users.php" class="return"><i class="fas fa-arrow-left"></i></a>
                <img src="php/images/<?php echo $row['image'] ?>" alt="" id="chat-user-img" class="pfp">
                <div class="user-details">
                    <span class="bold-name"><?php echo $row['uname'] ?></span>
                    <p><?php echo $row['status'] ?></p>
                </div>
            </header>
            <div class="chat-box" id="chat-box">
               
            </div>
            <div>
                <form action="" class="send-message" id="send-section" autocomplete="off">
                    <input type="text" name="send" value=<?php echo $_SESSION['unique_id']; ?> hidden>
                    <input type="text" name="receive-from" value=<?php echo $user_id; ?> hidden>
                    <input type="text" name="message" placeholder="Type your message here" class="message-content-send" id="message-content">
                    <button class="button send-button" id="message-send-btn"><i class="fab fa-telegram-plane"></i></button>
                </form>
            </div>
        </section> 
    </div>

    <script src="javascript/chat.js"></script>
    
</body>
</html>

