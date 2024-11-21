<?php
    include("../koneksi.php");

    // Retrieve form data
    $nama = $_POST['nama'];
    $harga = $_POST['harga'];
    $deskripsi = $_POST['deskripsi'];
    $id = $_POST['id'];

    // Check if form is submitted
    if (isset($_POST['simpan'])) {

        // Retrieve uploaded file info
        $foto = $_FILES['foto']['name'];
        $lokasi = $_FILES['foto']['tmp_name'];
        
        // Initialize the query for updating the record
        if (empty($foto)) {
            // No new photo, update without it
            $sql = "UPDATE minuman SET nama=?, harga=?, deskripsi=? WHERE id=?";
            $stmt = $konek->prepare($sql);
            $stmt->bind_param("sssi", $nama, $harga, $deskripsi, $id);
        } else {
            // Handle file upload: delete old photo and upload new one
            $query = mysqli_query($konek, "SELECT foto FROM minuman WHERE id='$id'");
            $row = mysqli_fetch_array($query);
            $oldFoto = $row['foto'];

            // Delete the old image
            if (!empty($oldFoto)) {
                $hapusfoto = "../foto-minuman/$oldFoto";
                if (file_exists($hapusfoto)) {
                    unlink($hapusfoto);
                }
            }

            // Move the uploaded file to the target directory
            $fotoPath = "../foto-minuman/" . $foto;
            move_uploaded_file($lokasi, $fotoPath);

            // Prepare the SQL to update the record with the new photo
            $sql = "UPDATE minuman SET nama=?, harga=?, foto=?, deskripsi=? WHERE id=?";
            $stmt = $konek->prepare($sql);
            $stmt->bind_param("ssssi", $nama, $harga, $foto, $deskripsi, $id);
        }

        // Execute the query and handle success/failure
        if ($stmt->execute()) {
            echo "<script> alert('Data berhasil diupdate!'); document.location.href='../admin-minuman.php'; </script>";
        } else {
            echo "<script> alert('Data gagal diupdate: " . $stmt->error . "'); document.location.href='../admin-minuman.php'; </script>";
        }

        // Close the prepared statement
        $stmt->close();
    } else {
        echo "<script> alert('Gagal Qimack...!!!!!'); document.location.href='../admin-minuman.php'; </script>";
    }
?>
