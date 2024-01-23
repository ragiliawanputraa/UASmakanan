<?php

require 'ceklogin.php';

if(isset($_GET['idp'])){
    $idp = $_GET['idp'];

    $ambilnamapelanggan = mysqli_query($conn, "select * from pesanan p, pelanggan pl where p.idpelanggan=pl.idpelanggan and p.idpesanan='$idp'");
    $np = mysqli_fetch_array($ambilnamapelanggan);
    $namapel = $np['namapelanggan'];

} else {
    header('location:index.php');
}

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Data Pesanan</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous" />
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
        <link href="https://fonts.googleapis.com/css2?family=Trade+Winds&display=swap" rel="stylesheet">

        <style>
            /* Gaya font untuk teks "Zar Otomotif" */
            .custom-font {
                font-family: 'Trade Winds', cursive; /* Sesuaikan nama font dengan yang diinginkan */
                /*Tambahkan properti lain sesuai kebutuhan, misalnya ukuran font, warna, dll.*/
            }

            .move-left {
            margin-left: -40px; /* Sesuaikan nilai negatif ini sesuai dengan seberapa jauh Anda ingin menggeser ke kiri */
            /*Tambahkan properti lain sesuai kebutuhan*/
        }

        </style>
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <div class="sb-nav-link-icon ml-3"><i class="fas fa-gear fa-spin" style="font-size:24px;color:red"></i></div>
            <!-- Navbar Brand-->
            <a class="navbar-brand ps-3 custom-font" href="index.php">Zar Automotive</a>
            <!-- Sidebar Toggle-->
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0 move-left" id="sidebarToggle" href="#!"><i class="fas fa-bars" style="font-size:21px"></i></button>
           
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <div class="sb-sidenav-menu-heading">Menu</div>
                            <a class="nav-link" href="dashboard.php">
                                <div class="sb-nav-link-icon"><i class="fa fa-bar-chart"></i></div>
                                Dashboard
                            </a>
                            <a class="nav-link" href="index.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-shopping-cart" style="color:yellow"></i></div>
                                Order
                            </a>
                            <a class="nav-link" href="stock.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-archive"></i></div>
                                Stock Barang
                            </a>
                            <a class="nav-link" href="masuk.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-cubes"></i></div>
                                Barang Masuk
                            </a>
                            <a class="nav-link" href="pelanggan.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-user-friends"></i></div>
                                Kelola Pelanggan
                            </a>
                            <a class="nav-link" href="logout.php">
                                <div class="sb-nav-link-icon"><i class="fa fa-sign-out" style="color:red"></i></div>
                                Logout
                            </a>
                        </div>
                    </div>
                    <div class="sb-sidenav-footer">
                        <div class="small">Logged in as:</div>
                        Admin
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Data Pesanan : <?=$idp;?></h1>
                        <h4 class="mt-3">Nama Pelanggan : <?=$namapel;?></h4>

                        <div class="row">
                            <!-- Bagian untuk Tambah Barang -->
                            <div class="col-md-6">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <i class="fas fa-receipt me-1"></i>
                                        Tambah Barang
                                    </div>
                                    <div class="card-body">
                                        <!-- Button to Open the Modal -->
                                        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal">
                                            Tambah Barang 
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Bagian untuk Struk -->
                            <div class="col-md-6">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <i class="fas fa-receipt me-1"></i>
                                        Struk Pembelian
                                    </div>
                                    <div class="card-body">
                                        <!-- Tampilkan detail struk di sini -->
                                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#receiptModal">
                                            Generate Struk
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                Data Pesanan
                            </div>
                            <div class="card-body">
                                <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Produk</th>
                                            <th>Harga Satuan</th>
                                            <th>Jumlah</th>
                                            <th>Sub-Total</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                            $get = mysqli_query($conn, "select * from detailpesanan p, produk pr where p.idproduk=pr.idproduk and idpesanan='$idp'");
                                            $i = 1;

                                            while($p=mysqli_fetch_array($get)){
                                            $idpr = $p['idproduk'];
                                            $iddp = $p['iddetailpesanan'];
                                            $qty = $p['qty'];
                                            $harga = $p['harga'];
                                            $namaproduk = $p['namaproduk'];
                                            $desc = $p['deskripsi'];
                                            $subtotal = $qty*$harga;
                           
                                        ?>

                                        <tr>
                                            <td> <?=$i++;?> </td>
                                            <td> <?=$namaproduk;?> (<?=$desc;?>) </td>
                                            <td>Rp<?=number_format($harga);?> </td>
                                            <td> <?=number_format($qty);?> </td>
                                            <td>Rp<?=number_format($subtotal);?> </td>
                                            <td>
                                            <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#edit<?=$idpr;?>">
                                                    edit
                                                </button>
                                                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#delete<?=$idpr;?>">
                                                    Delete
                                                </button>
                                            </td>
                                        </tr>
                                        
                                        <!-- The Modal Edit -->
                                        <div class="modal fade" id="edit<?=$idpr;?>">
                                            <div class="modal-dialog">
                                            <div class="modal-content">
                                            
                                                <!-- Modal Header -->
                                                <div class="modal-header">
                                                <h4 class="modal-title">Edit Data Detail Pesanan</h4>
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                </div>
                                                

                                                <form method="post">            
                                                    <!-- Modal body -->
                                                    <div class="modal-body">
                                                        <input type="text" name="namaproduk" class="form-control" placeholder="Nama Produk" value="<?=$namaproduk;?> : <?=$desc;?>" disabled>
                                                        <input type="number" name="qty" class="form-control mt-2" placeholder="qty" value="<?=$qty;?>">
                                                        <input type="hidden" name="iddp" value="<?=$iddp;?>">
                                                        <input type="hidden" name="idp" value="<?=$idp;?>">
                                                        <input type="hidden" name="idpr" value="<?=$idpr;?>">
                                                    </div>
                                                    
                                                    <!-- Modal footer -->
                                                    <div class="modal-footer">
                                                    <button type="submit" class="btn btn-success" name="editdetailpesanan">Submit</button>
                                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                    </div>
                                                </form>

                                            </div>
                                            </div>
                                        </div>


                                        <!-- The Modal Delete-->
                                        <div class="modal fade" id="delete<?=$idpr;?>">
                                            <div class="modal-dialog">
                                            <div class="modal-content">
                                            
                                                <!-- Modal Header -->
                                                <div class="modal-header">
                                                <h4 class="modal-title">Apakah Anda Yakin Ingin Menghapus Barang Ini?</h4>
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                </div>
                                                

                                                <form method="post">            
                                                    <!-- Modal body -->
                                                    <div class="modal-body">
                                                        Apakah Anda Yakin Ingin Menghapus Barang Ini?                                    
                                                        <input type="hidden" name="idp" value="<?=$iddp;?>">
                                                        <input type="hidden" name="idpr" value="<?=$idpr;?>">
                                                        <input type="hidden" name="idpesanan" value="<?=$idp;?>">
                                                    </div>
                                                    
                                                    <!-- Modal footer -->
                                                    <div class="modal-footer">
                                                    <button type="submit" class="btn btn-success" name="hapusprodukpesanan">Ya</button>
                                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Tidak</button>
                                                    </div>
                                                </form>

                                            </div>
                                            </div>
                                        </div>
                                        <?php
                                        };//end of while

                                        ?>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </main>
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Zar Automotive 2023</div>
                            <div>
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/chart-area-demo.js"></script>
        <script src="assets/demo/chart-bar-demo.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
        <script src="js/datatables-simple-demo.js"></script>
    </body>

    <!-- The Modal -->
    <div class="modal fade" id="myModal">
        <div class="modal-dialog">
        <div class="modal-content">
        
            <!-- Modal Header -->
            <div class="modal-header">
            <h4 class="modal-title">Pilih Barang</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            

            <form method="post">            
                <!-- Modal body -->
                <div class="modal-body">
                    Pilih Barang
                    <select name="idproduk" class="form-control">

                    <?php
                    $getproduk = mysqli_query($conn, "select * from produk where idproduk not in (select idproduk from detailpesanan where idpesanan='$idp')");

                    while($pl=mysqli_fetch_array($getproduk)){
                        $namaproduk = $pl['namaproduk'];
                        $stock = $pl['stock'];
                        $deskripsi = $pl['deskripsi'];
                        $idproduk = $pl['idproduk'];

                    
                    ?>

                    <option value="<?=$idproduk;?>"> <?=$namaproduk;?> - <?=$deskripsi;?> (Stock : <?=$stock;?>) </option>

                    <?php
                    }
                    ?>

                    </select>

                    <input type="number" name="qty" class="form-control mt-4" placeholder="Jumlah" min="1" required>
                    <input type="hidden" name="idp" value="<?=$idp;?>">

                </div>
                
                <!-- Modal footer -->
                <div class="modal-footer">
                <button type="submit" class="btn btn-success" name="addproduk">Submit</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </form>

        </div>
        </div>
    </div>

    <!-- Modal Struk -->
    <div class="modal fade" id="receiptModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <!-- Header Modal -->
                <div class="modal-header">
                    <h4 class="modal-title">Struk Pembelian</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Isi Modal -->
                <div class="modal-body">
                    <!-- Tampilkan detail struk secara dinamis menggunakan PHP -->
                    <h5 class="mb-2">ID Pesanan: <?= $idp; ?></h5>
                    <h5 class="mb-4">Atas Nama: <?= $namapel; ?></h5>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Produk</th>
                                <th>Harga Satuan</th>
                                <th>Jumlah</th>
                                <th>Sub-Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $total = 0;
                            $get = mysqli_query($conn, "SELECT * FROM detailpesanan p, produk pr WHERE p.idproduk=pr.idproduk AND idpesanan='$idp'");
                            $i = 1;
                            while ($p = mysqli_fetch_array($get)) {
                                $idpr = $p['idproduk'];
                                $iddp = $p['iddetailpesanan'];
                                $qty = $p['qty'];
                                $harga = $p['harga'];
                                $namaproduk = $p['namaproduk'];
                                $desc = $p['deskripsi'];
                                $subtotal = $qty * $harga;
                                $total += $subtotal;
                            ?>
                                <tr>
                                    <td><?= $i++; ?></td>
                                    <td><?= $namaproduk; ?> (<?= $desc; ?>)</td>
                                    <td>Rp<?= number_format($harga); ?></td>
                                    <td><?= number_format($qty); ?></td>
                                    <td>Rp<?= number_format($subtotal); ?></td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="4" class="text-end">Total:</th>
                                <th>Rp<?= number_format($total); ?></th>
                            </tr>
                        </tfoot>
                    </table>

                    <!-- Input Bayar -->
                    <div class="mb-3">
                        <label for="inputBayar" class="form-label">Bayar:</label>
                        <input type="number" class="form-control" id="inputBayar" name="bayar" placeholder="Masukkan jumlah pembayaran">
                    </div>

                    <!-- Input Kembalian (Disabled) -->
                    <div class="mb-3">
                        <label for="inputKembalian" class="form-label">Kembalian:</label>
                        <input type="number" class="form-control" id="inputKembalian" name="kembalian" placeholder="Kembalian" disabled>
                    </div>
                </div>

                <!-- Footer Modal -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary" onclick="printReceipt()">Cetak</button>
                </div>
            </div>
        </div>
    </div>

<!-- JavaScript untuk Menghitung Kembalian dan Mencetak Struk -->
    <script>
        function printReceipt() {
            // Dapatkan nilai pembayaran dan total
            var bayar = parseFloat(document.getElementById('inputBayar').value);
            var total = <?= $total; ?>; // Gunakan variabel PHP $total

            // Hitung kembalian
            var kembalian = bayar - total;

            // Dapatkan data lain yang ingin dicetak
            var idPesanan = <?= $idp; ?>;
            var namaPelanggan = "<?= $namapel; ?>";

            // Dapatkan tanggal saat ini
            var currentDate = new Date();
            var formattedDate = currentDate.toLocaleDateString('id-ID'); // Ganti 'id-ID' sesuai kebutuhan format tanggal

            // Buka jendela baru dengan konten yang dapat dicetak
            var printWindow = window.open('', '_blank');
            printWindow.document.write('<html><head><title>Struk Pembelian</title></head><body>');

            // Tambahkan data ke dalam jendela baru
            printWindow.document.write('<h3>Struk Pembelian</h3>');
            printWindow.document.write('<p>ID Pesanan: ' + idPesanan + '</p>');
            printWindow.document.write('<p>Atas Nama: ' + namaPelanggan + '</p>');
            printWindow.document.write('<p>Tanggal: ' + formattedDate + '</p>');

            // Tambahkan tabel tanpa border
            printWindow.document.write('<table>');
            printWindow.document.write('<thead><tr><th>No</th><th>Nama Produk</th><th>Harga Satuan</th><th>Jumlah</th><th>Sub-Total</th></tr></thead>');
            printWindow.document.write('<tbody>');

            <?php
            $i = 1;
            $get = mysqli_query($conn, "SELECT * FROM detailpesanan p, produk pr WHERE p.idproduk=pr.idproduk AND idpesanan='$idp'");
            while ($p = mysqli_fetch_array($get)) {
                $idpr = $p['idproduk'];
                $iddp = $p['iddetailpesanan'];
                $qty = $p['qty'];
                $harga = $p['harga'];
                $namaproduk = $p['namaproduk'];
                $desc = $p['deskripsi'];
                $subtotal = $qty * $harga;
            ?>
                printWindow.document.write('<tr>');
                printWindow.document.write('<td><?= $i++; ?></td>');
                printWindow.document.write('<td><?= $namaproduk; ?> (<?= $desc; ?>)</td>');
                printWindow.document.write('<td>Rp<?= number_format($harga); ?></td>');
                printWindow.document.write('<td><?= number_format($qty); ?></td>');
                printWindow.document.write('<td>Rp<?= number_format($subtotal); ?></td>');
                printWindow.document.write('</tr>');
            <?php
            }
            ?>

            printWindow.document.write('</tbody>');
            printWindow.document.write('<tfoot><tr><th colspan="4" class="text-end">Total:</th><th>Rp<?= number_format($total); ?></th></tr></tfoot>');
            printWindow.document.write('</table>');

            // Tambahkan informasi bayar dan kembalian dengan format angka
            printWindow.document.write('<p>Bayar: Rp' + bayar.toLocaleString() + '</p>');
            printWindow.document.write('<p>Kembalian: Rp' + kembalian.toLocaleString() + '</p>');

            printWindow.document.write('</body></html>');
            printWindow.document.close();

            // Cetak konten
            printWindow.print();
        }

        document.getElementById('inputBayar').addEventListener('input', function () {
            // Dapatkan nilai pembayaran dan total
            var bayar = parseFloat(this.value);
            var total = <?= $total; ?>; // Gunakan variabel PHP $total

            // Hitung kembalian dan perbarui input yang dinonaktifkan
            var kembalian = bayar - total;
            document.getElementById('inputKembalian').value = kembalian.toFixed(2);
        });
    </script>









</html>
