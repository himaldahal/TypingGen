<?php
include '../includes/config.php';
if(isset($_SESSION['username'])){
    header("Location: /typing.php");
    exit();
}

$message = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];

    // Perform login
    $query = "SELECT * FROM users WHERE username = ? LIMIT 1";
    $stmt = mysqli_prepare($conn, $query);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, 's', $username);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        if ($result && mysqli_num_rows($result) > 0) {
            $user = mysqli_fetch_assoc($result);
            
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $username;
                $_SESSION['fname'] = $user['fname'];

                mysqli_stmt_close($stmt);

                header("Location: /typing.php");
                exit();
            } else {
                $message = "Login failed. Incorrect password.";
            }
        } else {
            $message = "Login failed. User not found.";
        }

        mysqli_stmt_close($stmt);
    } else {
        $message = "Error in preparing the statement.";
    }
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .container {
            max-width: 400px;
            margin: 50px auto;
        }

        form {
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 10px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #17a2b8;
            color: #fff;
            border: none;
            cursor: pointer;
        }

        .message {
            margin-top: 15px;
            color: #17a2b8;
        }
    </style>
</head>
<body>
    <?php include '../includes/navbar.php'; ?>
    <div class="container">
        <h2>Register</h2>
        <form method="post" action="">
            <label for="reg_username">Username:</label>
            <input type="text" name="reg_username" required>

            <label for="reg_fname">Full Name:</label>
            <input type="text" name="reg_fname" required>

            <label for="reg_password">Password:</label>
            <input type="password" name="reg_password" required>
            <div class="message"><?php echo $message; ?></div>

            <button type="submit" name="register" class="btn btn-primary">Register</button>

        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
