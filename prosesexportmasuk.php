<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Data Barang Masuk.xls");
?>

<h3>Data Barang Masuk</h3>
		
<table border="1" cellpadding="5">
	<tr>
		<th>No</th>
		<th>Nama Produk</th>
		<th>Jumlah</th>
		<th>Tanggal</th>
	</tr>
	<?php
	include "function.php";
	
	$sql = mysqli_query($conn, "SELECT masuk.*, produk.namaproduk FROM masuk
                                INNER JOIN produk ON masuk.idproduk = produk.idproduk");
	
	$no = 1;
	while($data = mysqli_fetch_array($sql)){
		echo "<tr>";
		echo "<td>".$no."</td>";
		echo "<td>".$data['namaproduk']."</td>"; // Ganti dengan nama_produk
		echo "<td>".$data['qty']."</td>";
		echo "<td>".$data['tanggalmasuk']."</td>";
		echo "</tr>";
		
		$no++;
	}
	?>
</table>
