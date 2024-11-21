<?php
include("koneksi.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Using prepared statements for security
    $stmt = $konek->prepare("DELETE FROM nota WHERE id = ?");
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        echo "<script>document.location.href='logout.php'</script>";
    } else {
        echo "<script>document.location.href='logout.php'</script>";
    }

    $stmt->close();
} else {
    die("Akses Dilarang...!");
}
?>
