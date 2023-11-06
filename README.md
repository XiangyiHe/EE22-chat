# EE2E-chat

This chat provide you the opportunity to talk with your friends securely. 

# Concept used for End to end encryption
Each user registered have a set of private and public keys. Public key is available to everyone whereas private key is only
visible to the user themselves. When a sender send a message, the message will be encrypted with receiver's public key, when the 
receiver received the encrypted message, they can then decrypt the message using their private key, vice versa.

Throughout the process, the server will only have access to the encrypted message as well as public keys. It should not know the decrypted message
and will not have access to individual users' private key. 

In this chat app, when a user register an account, a pair of private and public key will be created. Public key will be stored in the database, as 
it's meant to be visible to everyone, where private key will be hashed first using an enviroment variable and then stored in a file locally. A file contains
pair of [encrypted message, decrypt message] will also be created. This will store all the message that sent by this register user. This helps with the
Frontend display later on. 

when a message is sent, it will be encrypt with receiver's public key and store the encrypted message in the database. When the receiver access it, the encrypted 
message will then be decrypted with receiver's private key. Since we have hash the private key to ensure further security, one need to unhash the security key first
before trying to decrypt the message.

When displaying the chat, depending on the message-sender. If the log-in user is the sender, user will obtain the decrypt message locally from the message file. Else 
they will decrypt the message using their private key.

# Register
You are firstly required to register. You will need to input username, email address and password. 
You will also need to upload an image as your profile picture. (As displayed below)
Keep in mind that password will be stored in the hashed way, hence the database will not have your real password but only the encrypted one. 
A one way hash algorithm have been used here so no one can decrypt it.

![image](https://github.com/XiangyiHe/EE22-chat/assets/97611121/b752dde3-4f7e-4774-83b4-d9b44458864e)

Errors will be display if your input does not fit the criteria (As displayed below)
![image](https://github.com/XiangyiHe/EE22-chat/assets/97611121/9665c1df-8881-4b18-a1bf-de3d6f9ae1e2)

If you already have an account, you can click on Login Now which then direct you to the login page.

When you register the account, a pair of public and private key will be generate for you which used for later on message encryption and decryption.
The public key will be stored in the database whereas the private key will be hashed with an environment viriable and then stored in a file locally
(so that only user can see the private key, server will not store it in the database)

In the meanwhile, another file for message send by you will be created locally, this is used to display decrypted message. As message will only be be 
stored in the encrypted way in database and can only be decrypted by the receiver's private key. You as the sender cannot decrypt the message, hence saving 
a record of all your sent message (before encryption) allows the display on Frontend later. 

# Login
Required matched registered email and password to log in. Sessions have been introduced here hence if you log in in one tab, you do not need to log in again. It will 
automatically log in for you.

Similar with Register, error will be displayed if the input is not correct. The server will firstly check if the email exist and then compared the hashpassword.


![image](https://github.com/XiangyiHe/EE22-chat/assets/97611121/0953e76a-0529-4562-af87-b89dce5a79cf)

# user-page
Once you log in/ registered you will be directed to your user page. Here on the top, you can see your username profile picture and status (online/offline). 
You can also see an logout button that allows you to log out. 

Below your user information, there's a search bar that allow you to search for user to chat with. 

Below the search bar is display of all users, search bar just provide easier way to quickly find the people you want to chat with. For each user you can see
their profile picture as well as status. If you have conversations with some user already, you are able to see the last message displayed.

![image](https://github.com/XiangyiHe/EE22-chat/assets/97611121/d5ea0415-70b4-437b-8722-6672fdafa326)

# search-bar

After clicking on the magnifying glass emoji, you can type in the username of the user you want to chat with. Depending on if the input query match anyone's 
username, you are able to see 2 different result as displayed.

![image](https://github.com/XiangyiHe/EE22-chat/assets/97611121/ec32720a-b738-4ce1-b86c-b597b900bd61)

![image](https://github.com/XiangyiHe/EE22-chat/assets/97611121/dc23c8a2-acd6-4946-a631-64de36996774)

# chat
When clicking on a user, you can start a chat with them!

At the top of the chat you can see the user's profile picture, name and status. The arrow allows you to navigate back to the user page. The chat page
is shown below. If there's multiple messages, you can scroll up and down to view them. 
![image](https://github.com/XiangyiHe/EE22-chat/assets/97611121/9e08ec7b-1591-4fc0-a608-aba839f58e3f)


# How to use it?
This is done using sql php javascript html and css. 
You need to ensure you have XAMPP installed and having a database with 2 tables created at http://localhost/phpmyadmin/

![image](https://github.com/XiangyiHe/EE22-chat/assets/97611121/00db4e4f-e6c8-48a0-8365-261749ff25b9)

Table messages structure - used to store message related info
![image](https://github.com/XiangyiHe/EE22-chat/assets/97611121/7de8af69-b198-4423-a2c2-de97d244471e)

Table users structure - used to store user related info
![image](https://github.com/XiangyiHe/EE22-chat/assets/97611121/3bb4f7b9-bb57-4127-93d2-041ceda536fa)

To run this locally make sure this folder is located inside xampp/htdocs, you can then run it using localhost/chat-project/register.php

In order for the encryption to work, ensure you have openssl and ensure you have create new system variable with Variable name: OPENSSL_CONF" and Variable value "C:\xampp\apache\conf\openssl.cnf".

Within the XAMPP control panel, click the config of module apache, httpd.conf, ensure you have set the encryption Key.
![image](https://github.com/XiangyiHe/EE22-chat/assets/97611121/10545612-1199-4f6a-a8c7-9ddc37d463ea)






