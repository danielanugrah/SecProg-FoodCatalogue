<?php
    include("../koneksi.php");

    // Ensure the form has been submitted before processing
    if (isset($_POST['simpan'])) {

        // Retrieve form data
        $nama = $_POST['nama'];
        $harga = $_POST['harga'];
        $deskripsi = $_POST['deskripsi'];

        // Handle the file upload
        if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
            $foto = $_FILES['foto']['name'];
            $lokasi = $_FILES['foto']['tmp_name'];

            // Validate file type (only allow JPG and PNG)
            $allowed_types = ['image/jpeg', 'image/png'];
            $file_type = mime_content_type($lokasi);
            if (!in_array($file_type, $allowed_types)) {
                echo "<script>alert('Hanya file JPG dan PNG yang diperbolehkan.'); document.location.href='../admin-minuman.php';</script>";
                exit;
            }

            // Validate file size (limit to 2MB)
            if ($_FILES['foto']['size'] > 2 * 1024 * 1024) {  // 2MB
                echo "<script>alert('Ukuran file terlalu besar. Maksimal 2MB.'); document.location.href='../admin-minuman.php';</script>";
                exit;
            }

            // Move the uploaded file to the target directory
            $target_dir = '../foto-minuman/';
            $target_file = $target_dir . basename($foto);
            if (!move_uploaded_file($lokasi, $target_file)) {
                echo "<script>alert('Gagal mengunggah foto.'); document.location.href='../admin-minuman.php';</script>";
                exit;
            }
        } else {
            echo "<script>alert('Gagal mengunggah foto.'); document.location.href='../admin-minuman.php';</script>";
            exit;
        }

        // Prepare SQL query using a prepared statement
        $stmt = $konek->prepare("INSERT INTO minuman (nama, harga, foto, deskripsi) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $nama, $harga, $foto, $deskripsi);

        // Execute the query and handle success/failure
        if ($stmt->execute()) {
            echo "<script>alert('Tambah menu Berhasil'); document.location.href='../admin-minuman.php';</script>";
        } else {
            echo "<script>alert('Tambah menu gagal: " . $stmt->error . "'); document.location.href='../admin-minuman.php';</script>";
        }

        // Close the prepared statement
        $stmt->close();
    } else {
        // If the form wasn't submitted properly, redirect to the admin page
        echo "<script>alert('Form belum disubmit.'); document.location.href='../admin-minuman.php';</script>";
    }
?>
