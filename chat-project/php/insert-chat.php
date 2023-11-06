<?php
    session_start();
    if(isset($_SESSION['unique_id'])) {
        include_once "config.php";
        $send_id = mysqli_real_escape_string($conn, $_POST['send']);
        $receive_id = mysqli_real_escape_string($conn, $_POST['receive-from']);
        $message_content = mysqli_real_escape_string($conn, $_POST['message']);

        $query = "SELECT public_key FROM users WHERE unique_id = '$receive_id'";
        $result = mysqli_query($conn, $query);


        if ($result) {
            if ($row = mysqli_fetch_assoc($result)) {

                $recipientPublicKey = $row['public_key'];
                openssl_public_encrypt($message_content, $encrypted, $recipientPublicKey);
                $encrypt_message = base64_encode($encrypted);
                

                mysqli_free_result($result);

                
                // Generate the filename based on a random ID
                $filenameMessage = $send_id . 'message.json';
                $folderName = "keys";
                $filepathMessage = __DIR__ . DIRECTORY_SEPARATOR . $folderName . DIRECTORY_SEPARATOR . $filenameMessage;

                $existingContent = file_get_contents($filepathMessage);
                $existingData = json_decode($existingContent, true);

                $messageData = [
                    'encrypted_message' => $encrypt_message,
                    'original_message' => $message_content,
                ];

                $existingData[] = $messageData;

                // Save the data to the JSON file
                $newContent = json_encode($existingData, JSON_PRETTY_PRINT);
                file_put_contents($filepathMessage, $newContent);

                
                if(!empty($encrypt_message)) {
                    $sql = mysqli_query($conn, "INSERT INTO messages (received_msg_id, sent_msg_id, message_content)
                                        VALUES ({$receive_id}, {$send_id}, '{$encrypt_message}')");
                } else {
                    $sql = mysqli_query($conn, "INSERT INTO messages (received_msg_id, sent_msg_id, message_content)
                                        VALUES ({$receive_id}, {$send_id}, '{$message_content}')");
                }


            } else {
                echo "Recipient not found or public key not available.";
            }
        } else {
            echo "Error querying the database: " . mysqli_error($conn);
        }

    } else {
        header("../login.php");
    }
?>

