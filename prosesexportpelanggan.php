<?php
// Skrip berikut ini adalah skrip yang bertugas untuk meng-export data tadi ke excell
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Data Pelanggan.xls");
?>

<h3>Data Pelanggan</h3>
		
<table border="1" cellpadding="5">
	<tr>
		<th>No</th>
		<th>Nama Pelanggan</th>
		<th>Nomor Telp</th>
		<th>Alamat</th>
	</tr>
	<?php
	// Load file koneksi.php
	include "function.php";
	
	// Buat query untuk menampilkan semua data siswa
	$sql = mysqli_query($conn, "SELECT * FROM pelanggan");
	
	$no = 1; // Untuk penomoran tabel, di awal set dengan 1
	while($data = mysqli_fetch_array($sql)){ // Ambil semua data dari hasil eksekusi $sql
		echo "<tr>";
		echo "<td>".$no."</td>";
		echo "<td>".$data['namapelanggan']."</td>";
		echo "<td>".$data['notelp']."</td>";
		echo "<td>".$data['alamat']."</td>";
		echo "</tr>";
		
		$no++; // Tambah 1 setiap kali looping
	}
	?>
</table>