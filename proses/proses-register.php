<?php
include("../koneksi.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize and trim inputs
    $nama = trim($_POST['nama']);
    $email = trim($_POST['email']);
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $alamat = trim($_POST['alamat']);

    // Validate inputs
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script> alert('Invalid email format'); document.location.href='../register.php'</script>";
        exit();
    }

    if (empty($nama) || empty($username) || empty($password) || empty($alamat)) {
        echo "<script> alert('All fields are required'); document.location.href='../register.php'</script>";
        exit();
    }

    // Hash the password before storing it
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Use prepared statements to avoid SQL injection
    $stmt = $konek->prepare("SELECT * FROM user WHERE username = ? OR email = ?");
    $stmt->bind_param("ss", $username, $email);  // "ss" means two string parameters
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<script> alert('Username or email is already taken'); document.location.href='../register.php'</script>";
    } else {
        // Insert the new user into the database
        $stmt = $konek->prepare("INSERT INTO user (nama, email, username, pass, alamat) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $nama, $email, $username, $hashedPassword, $alamat);

        if ($stmt->execute()) {
            echo "<script> alert('Registration successful!'); document.location.href='../login.php'</script>";
        } else {
            echo "<script> alert('Registration failed, please try again'); document.location.href='../register.php'</script>";
        }
    }

    $stmt->close();  // Close the statement
}
?>
