<?php
include("koneksi.php");

if (isset($_GET['id'])) {
    // Sanitize the ID
    $id = (int) $_GET['id'];

    // Prepare the SQL statement
    $stmt = $konek->prepare("DELETE FROM menu WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "<script> alert('Data Berhasil Dihapus'); document.location.href='admin-menu.php'</script>";
    } else {
        echo "<script> alert('Gagal Menghapus...!'); document.location.href='admin-menu.php'</script>";
    }
    $stmt->close();
} else {
    die("Akses Dilarang...!");
}
?>
