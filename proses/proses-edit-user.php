<?php
    include("../koneksi.php");

    // Ensure the form has been submitted before processing
    if (isset($_POST['daftar'])) {
        // Retrieve form data
        $id = $_POST['id'];
        $nama = $_POST['nama'];
        $email = $_POST['email'];
        $username = $_POST['username'];
        $pass = $_POST['password'];
        $alamat = $_POST['alamat'];

        // Basic validation to check required fields
        if (empty($nama) || empty($email) || empty($username) || empty($pass) || empty($alamat)) {
            echo "<script>alert('Semua field harus diisi!'); document.location.href='../admin.php';</script>";
            exit;
        }

        // Hash the password before updating (if changed)
        $hashed_pass = password_hash($pass, PASSWORD_DEFAULT);

        // Prepare the SQL query using a prepared statement to prevent SQL injection
        $stmt = $konek->prepare("UPDATE user SET nama=?, email=?, username=?, pass=?, alamat=? WHERE id=?");
        $stmt->bind_param("sssssi", $nama, $email, $username, $hashed_pass, $alamat, $id);

        // Execute the query and handle success/failure
        if ($stmt->execute()) {
            echo "<script>alert('Data Berhasil di Edit'); document.location.href='../admin.php';</script>";
        } else {
            echo "<script>alert('Data Gagal di Edit: " . $stmt->error . "'); document.location.href='../admin.php';</script>";
        }

        // Close the prepared statement
        $stmt->close();
    } else {
        // If the form wasn't submitted properly, terminate the script
        die("Akses Dilarang...!");
    }
?>
