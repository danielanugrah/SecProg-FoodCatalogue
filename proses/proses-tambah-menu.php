<?php
include("../koneksi.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize user inputs
    $nama = htmlspecialchars(trim($_POST['nama']));
    $harga = $_POST['harga'];
    $jenis = htmlspecialchars(trim($_POST['jenis']));
    $deskripsi = htmlspecialchars(trim($_POST['deskripsi']));

    // File upload handling
    $foto = $_FILES['foto'];
    $targetDir = "../foto-menu/";
    $targetFile = $targetDir . basename($foto['name']);
    $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Validate image file
    if (!in_array($fileType, ['jpg', 'jpeg', 'png', 'gif'])) {
        echo "<script> alert('Invalid file format. Only JPG, JPEG, PNG, GIF are allowed.'); document.location.href='../tambah-menu.php'</script>";
        exit();
    }

    // Move the file to the server directory
    if (move_uploaded_file($foto['tmp_name'], $targetFile)) {
        // Insert the menu data using prepared statement
        $stmt = $konek->prepare("INSERT INTO menu (nama, harga, jenis, deskripsi, foto) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sisss", $nama, $harga, $jenis, $deskripsi, $foto['name']);
        if ($stmt->execute()) {
            echo "<script> alert('Menu added successfully!'); document.location.href='../menu.php'</script>";
        } else {
            echo "<script> alert('Error adding menu'); document.location.href='../tambah-menu.php'</script>";
        }
        $stmt->close();
    } else {
        echo "<script> alert('Failed to upload image.'); document.location.href='../tambah-menu.php'</script>";
    }
}
?>
