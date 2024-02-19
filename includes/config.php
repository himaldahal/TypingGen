<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$db_host = 'localhost';
$db_user = 'root';
$db_pwd = '';
$db_name = 'typinggen';

$conn = new mysqli($db_host, $db_user, $db_pwd, $db_name);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql_script = "
            CREATE TABLE IF NOT EXISTS `users` (
                id INT AUTO_INCREMENT PRIMARY KEY,
                username VARCHAR(255) NOT NULL,
                fname VARCHAR(255) NOT NULL,
                password VARCHAR(255) NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            );
            CREATE TABLE IF NOT EXISTS `records` (
                `id` INT AUTO_INCREMENT PRIMARY KEY,
                `user_id` INT NOT NULL,
                `wpm` INT,
                `cpm` INT,
                `mistakes` INT,
                `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (user_id) REFERENCES users(id)
            );";
        
if ($conn->multi_query($sql_script)) {
            do {
                if ($result = $conn->store_result()) {
                    $result->free();
                }
        } while ($conn->more_results() && $conn->next_result());
} else {
        echo "Error executing SQL script: " . $conn->error;
        exit();
}

?>
