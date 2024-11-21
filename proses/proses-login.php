<?php

header('Strict-Transport-Security: max-age=31536000; includeSubDomains; preload');
header("X-Content-Type-Options: nosniff");
header("X-Frame-Options: SAMEORIGIN");

session_start();
// Secure session settings (place this at the top of your PHP script)
ini_set('session.cookie_httponly', 1); // Prevent JavaScript access to session cookie
ini_set('session.cookie_secure', 1);   // Only send cookies over HTTPS
ini_set('session.use_only_cookies', 1); // Ensure cookies are used for session management

// Regenerate session ID to prevent session fixation attacks
session_regenerate_id();
include("../koneksi.php");

$username = trim($_POST['username']);
$password = trim($_POST['password']);

// Validate username
if (!preg_match('/^[a-zA-Z0-9_]+$/', $username)) {
    echo "<script> alert('Username contains invalid characters'); document.location.href='../login.php'</script>";
    exit();
}

try {
    // Prepare the SQL statement to avoid SQL injection
    $stmt = $konek->prepare("SELECT * FROM user WHERE username = ?");
    $stmt->bind_param("s", $username);  // "s" indicates the type is string
    $stmt->execute();
    $result = $stmt->get_result();
    
    // Check if a user is found
    $user = $result->fetch_assoc();

    if ($user) {
        // Verify the password (password stored securely using password_hash)
        if (password_verify($password, $user['pass'])) {
            // Regenerate session ID to prevent fixation attacks
            session_regenerate_id(true);

            // Set session variables
            $_SESSION['username'] = $user['username'];
            $_SESSION['hak'] = $user['hak'];
            $_SESSION['pelanggan'] = $user;

            // Redirect based on user role
            if ($user['hak'] == "admin") {
                echo "<script> alert('Selamat datang admin'); document.location.href='../admin.php'</script>";
            } else {
                echo "<script> alert('Selamat datang'); document.location.href='../index.php'</script>";
            }
        } else {
            // Password mismatch
            echo "<script> alert('Username atau password anda salah'); document.location.href='../login.php'</script>";
        }
    } else {
        // User not found
        echo "<script> alert('Anda belum terdaftar'); document.location.href='../register.php'</script>";
    }

    // Close the prepared statement
    $stmt->close();
} catch (Exception $e) {
    // Log the error and show a generic message to the user
    error_log($e->getMessage(), 3, '/var/log/app_errors.log');
    echo "<script> alert('Terjadi kesalahan. Coba lagi nanti.'); document.location.href='../login.php'</script>";
}
?>
