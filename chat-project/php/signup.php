<?php
session_start();
include_once "config.php";

$uname = mysqli_real_escape_string($conn, $_POST['uname']);
$email = mysqli_real_escape_string($conn, $_POST['email']);
$password = mysqli_real_escape_string($conn, $_POST['password']);
$passwordConfirm = mysqli_real_escape_string($conn, $_POST['passwordConfirm']);

if (!empty($uname) && !empty($email) && !empty($password) && !empty($passwordConfirm)) {
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $sql = mysqli_query($conn, "SELECT email FROM users WHERE email = '{$email}'");
        if (mysqli_num_rows($sql) > 0) {
            echo "Email already registered";
        } else {
            if ($password == $passwordConfirm) {
                if (isset($_FILES['image'])) {
                    $img_name = $_FILES['image']['name'];
                    $img_tmp_name = $_FILES['image']['tmp_name'];
                    $img_explode = explode('.', $img_name);
                    $img_ext = end($img_explode);

                    $extensions = ['jpeg', 'png', 'jpg'];

                    if (in_array($img_ext, $extensions)) {
                        $time = time();
                        $new_img_name = $time . $img_name;
                        if (move_uploaded_file($img_tmp_name, "images/" . $new_img_name)) {
                            $status = "Online";
                            $random_id = rand(time(), 10000000);

                            // Generate a new private (and public) key pair
                            $keyPair = openssl_pkey_new(array(
                                "private_key_bits" => 2048,
                                "private_key_type" => OPENSSL_KEYTYPE_RSA,
                             ));
                            
                            openssl_pkey_export($keyPair, $privateKey);

                            // Extract the public key
                            $publicKeyDetails = openssl_pkey_get_details($keyPair);
                            $publicKey = $publicKeyDetails['key'];

                            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                            $sql2 = mysqli_query($conn, "INSERT INTO users(unique_id, uname, email, password, image, status, public_key)
                                                 VALUES ({$random_id}, '{$uname}', '{$email}', '{$hashed_password}', '{$new_img_name}', '{$status}', '{$publicKey}')");

                            if ($sql2) {
                                $sql3 = mysqli_query($conn, "SELECT * FROM users WHERE email = '{$email}'");
                                if (mysqli_num_rows($sql3) > 0) {
                                    $row = mysqli_fetch_assoc($sql3);

                                    $encryptionKey = getenv('ENCRYPTION_KEY');

                                    $encryptedPrivateKey = openssl_encrypt($privateKey, 'aes-256-cbc', $encryptionKey, 0, 'COMP6841COMP6841');


                                    // Generate the filename based on the user's email
                                    $folderName = 'keys';
                                    $filename = $random_id . '_private_key.enc.pem';
                                    $filenameMessage = $random_id . 'message.json';

                                    $filepath = __DIR__ . DIRECTORY_SEPARATOR . $folderName . DIRECTORY_SEPARATOR . $filename;
                                    $filepathMessage = __DIR__ . DIRECTORY_SEPARATOR . $folderName . DIRECTORY_SEPARATOR . $filenameMessage;

                                    // Save the encrypted private key to a file
                                    file_put_contents($filepath, $encryptedPrivateKey);
                                    // file_put_contents($filepath, $encryptedPrivateKey);
                                    file_put_contents($filepathMessage, json_encode([]));

                                    $_SESSION['unique_id'] = $row['unique_id'];
                                    echo "success";
                                }
                            } else {
                                echo "Something went wrong";
                            }
                        }
                    } else {
                        echo "Only png jpeg jpg Images are accepted";
                    }
                } else {
                    echo "Please select an image for the profile picture";
                }
            } else {
                echo "Password and Confirmed Password need to be consistent";
            }
        }
    } else {
        echo "$email is not a valid email";
    }
} else {
    echo "All inputs are required";
}
?>
