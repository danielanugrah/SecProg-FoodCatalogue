<?php 
include("koneksi.php");
session_start();
?>

<!DOCTYPE html>
<html>
<head>
	<title>Menu Makanan</title>
	<style type="text/css">
		/* Your existing styles */
	</style>
</head>
<body>
	<?php
		// Fetch user details using prepared statement
		if(isset($_SESSION['username'])) {
			$sql1 = $konek->prepare("SELECT * FROM user WHERE username = ?");
			$sql1->bind_param("s", $_SESSION['username']);
			$sql1->execute();
			$hasil1 = $sql1->get_result();
		}
	?>
	<table align="center" class="tabheader">
		<tr>
			<td height="70" width="800" align="center">Menu Makanan</td>
			<?php if(isset($_SESSION['pelanggan'])): ?>
			<td width="300" align="center">| User : [<?php echo $_SESSION['username']; ?>]</td>
			<td width="200" align="center"><a href="index.php">Home</a></td>
			<?php endif ?>
		</tr>
	</table>
	<?php
		// Prepared statement for fetching menu items
		$sql = "SELECT * FROM menu";
		$hasil = mysqli_query($konek, $sql);
		while($data = mysqli_fetch_array($hasil)) {
	?>
	<div class="card">
		<div class="poster">
			<img src="foto-menu/<?php echo htmlspecialchars($data['foto']); ?>" alt="Menu Image">
			<div class="details">
				<h2><?php echo htmlspecialchars($data['nama']); ?><br><span>Directed by Happy Food</span><span> | Rp. <?php echo number_format($data['harga']); ?></span></h2>
				<div class="info">
					<p><?php echo htmlspecialchars($data['deskripsi']); ?></p>
				</div>
			</div>
		</div>
	</div>
	<?php } ?>

	<table align="center">
		<tr>
			<td height="80"></td>
		</tr>
		<tr>
			<td height="45" width="100" align="center" class="td">
			<a href="menuminum.php">Menu Minuman</a>
			</td>
		</tr>
		<tr>
			<td height="80"></td>
		</tr>
	</table>
</body>
</html>
