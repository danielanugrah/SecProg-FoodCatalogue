<?php
include("koneksi.php");
session_start();

// Ensure 'totalal' is set and only update 'total' if a valid total exists
if (isset($_SESSION['totalal']) && isset($_SESSION['total'])) {
    $total = $_SESSION['total'] + $_SESSION['totalal']; // Adding total price to previous total
} else {
    $total = 0; // If not set, initialize total as 0
}

if (isset($_POST['cetak']) || isset($_POST['cetakan'])) {
    // Store nota in the database
    $namauser = $_SESSION['pelanggan']['nama'];
    $tanggal = date("Y-m-d");

    // Insert into the 'nota' table
    $sql = $konek->prepare("INSERT INTO nota (nama_pelanggan, tanggal, total) VALUES (?, ?, ?)");
    $sql->bind_param("ssi", $namauser, $tanggal, $total);
    $sql->execute();
    $sql->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Nota</title>
    <style type="text/css">
        body {
            background: url(gambar/mk0.png);
            background-size: cover;
            margin: 0;
        }
        table {
            width: 40%;
        }
        header {
            background: tomato;
            height: 100px;
        }
        h1 {
            margin: 0;
            color: white;
            font-family: Agency FB;
            font-size: 65px;
            padding: 10px 20px 20px 50px;
        }
        .bungkus {
            margin-top: 20px;
            margin-left: 300px;
            width: 100%;
        }
        table {
            margin-top: 10px;
            margin-bottom: 20px;
            font-family: sans-serif;
            background: rgba(0,0,0,0.5);
            width: 50%;
            text-align: center;
        }
        table th {
            background: #e8e27d;
            height: 25px;
        }
        table td {
            background: #e8bb7c;
        }
        .nav a {
            background: orange;
            padding: 5px 10px;
            color: white;
            text-decoration: none;
            font-family: sans-serif;
            font-size: 18px;
            border: 2px solid white;
        }
    </style>
</head>
<body>

<header>
    <h1>Nota Pembelian</h1>
</header>
<div class="bungkus">
    <table border="1">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Tanggal</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <?php $nomor = 1; ?>
            <?php
            // Fetch nota records for the logged-in user
            $ambil = $konek->query("SELECT * FROM nota WHERE nama_pelanggan='$namauser'");
            while ($pecah = $ambil->fetch_assoc()) {
            ?>
                <tr>
                    <td><?php echo $nomor; ?></td>
                    <td><?php echo $pecah['nama_pelanggan']; ?></td>
                    <td><?php echo $pecah['tanggal']; ?></td>
                    <td>Rp. <?php echo number_format($pecah['total']); ?></td>
                </tr>
            <?php $nomor++; } ?>
        </tbody>
    </table>
    <div class="nav">
        <a href="hapusnot1.php?id=<?php echo $pecah['id']; ?>">Home</a>
        <a href="hapusnot2.php?id=<?php echo $pecah['id']; ?>">Logout</a>
    </div>
</div>
</body>
</html>
