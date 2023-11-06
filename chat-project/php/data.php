<?php
    while($row = mysqli_fetch_assoc($sql)) {
        $sql2 = "SELECT * FROM messages 
                WHERE (received_msg_id = {$row['unique_id']} OR sent_msg_id = {$row['unique_id']}) 
                AND (received_msg_id= {$send_id} OR sent_msg_id = {$send_id}) 
                ORDER BY message_id DESC 
                LIMIT 1";

        
        $query2 = mysqli_query($conn, $sql2);
        $row2 = mysqli_fetch_assoc($query2);
        
        if (mysqli_num_rows($query2) > 0) {
            $result = $row2['message_content'];
        } else {
            $result = "No message available";
        }


        $sender = "";

        if (isset($row2['sent_msg_id'])) {
            if ($send_id == $row2['sent_msg_id']) {

                $filenameMessage = $send_id . 'message.json';
                $folderName = "keys";
                $filepathMessage = __DIR__ . DIRECTORY_SEPARATOR . $folderName . DIRECTORY_SEPARATOR . $filenameMessage;

                if (file_exists($filepathMessage) && file_get_contents($filepathMessage) !== false) {
                    $fileContent = file_get_contents($filepathMessage);
                    $messageDataArray = json_decode($fileContent, true);
                
                    if ($messageDataArray !== null && is_array($messageDataArray)) {
                        // Iterate through each message pair in the file
                        foreach ($messageDataArray as $messageData) {
                            // Compare the encrypted message with the one from the database
                            $encryptedMessageFromFile = $messageData['encrypted_message'];
                
                            if ($encryptedMessageFromFile === $result) {
                                // The encrypted message exists in the file
                                $result = $messageData['original_message'];
                            }
                        }
                    }
                }
                $sender = "You: ";
            } else {
                $folderName = 'keys';
                    $filename = $send_id . '_private_key.enc.pem';
                    $filepath = __DIR__ . DIRECTORY_SEPARATOR . $folderName . DIRECTORY_SEPARATOR . $filename;

                    $privateKeyContent = file_get_contents($filepath);
                    $encryptionKey = getenv('ENCRYPTION_KEY'); 

                    if ($privateKeyContent !== false) {
                        // Load the private key
                        $decryptedPrivateKey = openssl_decrypt($privateKeyContent, 'aes-256-cbc', $encryptionKey, 0, 'COMP6841COMP6841');

                        openssl_private_decrypt(base64_decode($result), $result, $decryptedPrivateKey);
                    }
                $sender = "";
            }

        } else {
            $sender = "";
        }   

        (strlen($result) > 25) ? $message = substr($result, 0, 25).'...' : $message = $result;
        
        ($row['status'] == "offline") ? $offline = "offline" : $offline = "";

        $output .= '<a href="chat.php?user_id='.$row['unique_id'].'" class="list-users-idv user-info">
                    <div class="user-content">
                        <img src="php/images/'. $row['image'] .'" alt="" class="pfp" id="idv-img">
                        <div class="user-details">
                            <span class="bold-name">'. $row['uname'] .'</span>
                            <p class="message">' . $sender .$message. '</p>
                        </div>
                    </div>
                    <div class="status-dot '.$offline.'"><i class="fas fa-circle"></i></div>
                    </a>';
    
    }
?>
