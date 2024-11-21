<?php

// Set security-related HTTP headers
header('Strict-Transport-Security: max-age=31536000; includeSubDomains; preload');
header("X-Content-Type-Options: nosniff");
header("X-Frame-Options: SAMEORIGIN");

session_start();

// Function to generate CSRF token
function generate_csrf_token() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="css/login.css">
</head>
<body>

    <div class="box">
        <div class="left"></div>
        <div class="right">
            <div class="formbox">
                <form action="proses/proses-login.php" method="post">

                    <!-- CSRF Token -->
                    <input type="hidden" name="csrf_token" value="<?php echo generate_csrf_token(); ?>">

                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" placeholder="Username" required="">

                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Password" required="">

                    <input type="submit" name="login" value="Login">
                    <p>Don't have an account yet? <a href="register.php">Register</a></p>
                </form>
            </div>
        </div>
    </div>

</body>
</html>
