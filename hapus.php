<?php
include("koneksi.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Using prepared statements for security against SQL injection
    $stmt = $konek->prepare("DELETE FROM user WHERE id = ?");
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        echo "<script> alert('Data Berhasil Dihapus'); document.location.href='admin-user.php'</script>";
    } else {
        echo "<script> alert('Gagal Menghapus...!'); document.location.href='admin-user.php'</script>";
    }

    $stmt->close();
} else {
    die("Akses Dilarang...!");
}
?>
