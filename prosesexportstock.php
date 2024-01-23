<?php
// Skrip berikut ini adalah skrip yang bertugas untuk meng-export data tadi ke excell
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Data Stock Barang.xls");
?>

<h3>Data Stock Barang</h3>
		
<table border="1" cellpadding="5">
	<tr>
		<th>No</th>
		<th>Nama Produk</th>
		<th>Deskripsi</th>
		<th>Stock</th>
		<th>Harga</th>
	</tr>
	<?php
	// Load file koneksi.php
	include "function.php";
	
	// Buat query untuk menampilkan semua data siswa
	$sql = mysqli_query($conn, "SELECT * FROM produk");
	
	$no = 1; // Untuk penomoran tabel, di awal set dengan 1
	while($data = mysqli_fetch_array($sql)){ // Ambil semua data dari hasil eksekusi $sql
		echo "<tr>";
		echo "<td>".$no."</td>";
		echo "<td>".$data['namaproduk']."</td>";
		echo "<td>".$data['deskripsi']."</td>";
		echo "<td>".$data['harga']."</td>";
		echo "<td>".$data['stock']."</td>";
		echo "</tr>";
		
		$no++; // Tambah 1 setiap kali looping
	}
	?>
</table>