<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Data Pesanan.xls");
?>

<h3>Data Pesanan</h3>
		
<table border="1" cellpadding="5">
	<tr>
		<th>No</th>
		<th>Id Pesanan</th>
		<th>Nama Pemesan</th>
		<th>Nama Barang</th>
		<th>Qty</th>
		<th>Harga</th> <!-- Added column for Harga -->
	</tr>
	<?php
	include "function.php";
	
    $sql = mysqli_query($conn, "SELECT dp.*, p.idpelanggan, pl.namapelanggan, pr.namaproduk, pr.harga
                                FROM detailpesanan dp
                                JOIN pesanan p ON dp.idpesanan = p.idpesanan
                                JOIN produk pr ON dp.idproduk = pr.idproduk
                                JOIN pelanggan pl ON p.idpelanggan = pl.idpelanggan");

	$no = 1;
	while($data = mysqli_fetch_array($sql)){
		echo "<tr>";
		echo "<td>".$no."</td>";
		echo "<td>".$data['idpesanan']."</td>"; 
		echo "<td>".$data['namapelanggan']."</td>";
		echo "<td>".$data['namaproduk']."</td>";
		echo "<td>".$data['qty']."</td>";
		echo "<td>".($data['qty'] * $data['harga'])."</td>"; //calculate and display harga
		echo "</tr>";
		
		$no++;
	}
	?>
</table>
