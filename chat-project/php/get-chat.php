<?php
    session_start();
    if(isset($_SESSION['unique_id'])) {
        include_once "config.php";
        $send_id = mysqli_real_escape_string($conn, $_POST['send']);
        $receive_id = mysqli_real_escape_string($conn, $_POST['receive-from']);
        $output = "";

        $sql = "SELECT * FROM messages 
                LEFT JOIN users ON users.unique_id = messages.sent_msg_id
                WHERE (sent_msg_id = {$send_id}) AND (received_msg_id = {$receive_id}) OR 
                (sent_msg_id = {$receive_id}) AND (received_msg_id = {$send_id}) ORDER BY message_id";

        $query = mysqli_query($conn, $sql);

        if (mysqli_num_rows($query) > 0) {

            $filenameMessage = $send_id . 'message.json';
            $folderName = "keys";
            $filepathMessage = __DIR__ . DIRECTORY_SEPARATOR . $folderName . DIRECTORY_SEPARATOR . $filenameMessage;

            while ($row = mysqli_fetch_assoc($query)) {
                if ($row['sent_msg_id'] === $send_id) {


                    if (file_exists($filepathMessage) && file_get_contents($filepathMessage) !== false) {
                        $fileContent = file_get_contents($filepathMessage);
                        // Decode the JSON content
                        $messageDataArray = json_decode($fileContent, true);
                    
                        if ($messageDataArray !== null && is_array($messageDataArray)) {
                            // Iterate through each message pair in the file
                            foreach ($messageDataArray as $messageData) {
                                // Compare the encrypted message with the one from the database
                                $encryptedMessageFromFile = $messageData['encrypted_message'];
                    
                                if ($encryptedMessageFromFile === $row['message_content']) {
                                    // The encrypted message exists in the file
                                    $originalMessage = $messageData['original_message'];
                    
                                    $output .= '<div class="chat-message">
                                                    <div class="message-details sent">
                                                        <p class="message-content-sent">' . $originalMessage . '</p>
                                                    </div>
                                                </div>';
                    
                                    // Exit the loop since we found a match
                                    break;
                                }
                            }
                    
                            // Handle the case where the encrypted message doesn't exist in the file
                            if (empty($output)) {
                                $output .= '<div class="chat-message">
                                                <div class="message-details sent">
                                                    <p class="message-content-sent">Encrypted message not found in the file.</p>
                                                </div>
                                            </div>';
                            }
                        }
                    } else {
                        $output .= '<div class="chat-message">
                                    <div class="message-details sent">
                                        <p class="message-content-sent">' .$row['message_content']. '</p>
                                    </div>
                                </div>';
                    }

                } else {
                    $folderName = 'keys';
                    $filename = $send_id . '_private_key.enc.pem';
                    $filepath = __DIR__ . DIRECTORY_SEPARATOR . $folderName . DIRECTORY_SEPARATOR . $filename;

                    $privateKeyContent = file_get_contents($filepath);
                    $encryptionKey = getenv('ENCRYPTION_KEY'); 

                    if ($privateKeyContent !== false) {
                        // Load the private key
                        $decryptedPrivateKey = openssl_decrypt($privateKeyContent, 'aes-256-cbc', $encryptionKey, 0, 'COMP6841COMP6841');

                        openssl_private_decrypt(base64_decode($row['message_content']), $decryptedMessage, $decryptedPrivateKey);
                        
                        
                        $output .= '<div class="chat-message">
                                    <div class="message-details received">
                                        <img src="php/images/'.$row['image'].'" alt="" id="chat-message-img-rec" class="pfp chat-img">
                                        <p class="message-content-received">' .$decryptedMessage. '</p>
                                    </div>
                                </div>';

                    } else {
                        $output .= '<div class="chat-message">
                                    <div class="message-details received">
                                        <img src="php/images/'.$row['image'].'" alt="" id="chat-message-img-rec" class="pfp chat-img">
                                        <p class="message-content-received">' .$row['message_content']. '</p>
                                    </div>
                                </div>';
                    }
                    
                }
            } 
            echo $output;
        }
    } else {
        header("../login.php");
    }
?>