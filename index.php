<?php
require 'ceklogin.php';

$sql = "SELECT MONTH(pesanan.tanggal) AS month, SUM(detailpesanan.qty) AS total_qty_terjual
        FROM pesanan pesanan
        JOIN detailpesanan detailpesanan ON pesanan.idpesanan = detailpesanan.idpesanan
        GROUP BY MONTH(pesanan.tanggal)";
$result = mysqli_query($conn, $sql);

$labels = [];
$data = [];

while ($row = mysqli_fetch_assoc($result)) {
    $labels[] = date("F", mktime(0, 0, 0, $row['month'], 1));
    $data[] = $row['total_qty_terjual'];
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
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

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
                        <h1 class="mt-4 mb-3">Data Pesanan</h1>
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-receipt me-1"></i>
                                Tambah Pesanan
                            </div>
                            <div class="card-body">
                                <!-- Button to Open the Modal -->
                                <button type="button" class="btn btn-info mb-2" data-toggle="modal" data-target="#myModal">
                                    Tambah Pesanan Baru
                                </button>
                                <button type="button" class="btn btn-success mb-2" onclick="exportToExcel()">
                                    Export Excel
                                </button>
                                <script>
                                    function exportToExcel() {
                                        // Mengarahkan ke prosesexportstock.php
                                        window.location.href = 'prosesexportindex.php';
                                    }
                                </script>
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
                                            <th>ID Pesanan</th>
                                            <th>Tanggal</th>
                                            <th>Nama Pelanggan</th>
                                            <th>Jumlah</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                            $get = mysqli_query($conn, "select * from pesanan p, pelanggan pl where p.idpelanggan=pl.idpelanggan");

                                            while($p=mysqli_fetch_array($get)){
                                            $idpesanan = $p['idpesanan'];
                                            $tanggal = $p['tanggal'];
                                            $namapelanggan = $p['namapelanggan'];
                                            $alamat = $p['alamat'];

                                            //hitung jumlah
                                            $hitungjumlah = mysqli_query($conn, "select * from detailpesanan where idpesanan ='$idpesanan'");
                                            $jumlah = mysqli_num_rows($hitungjumlah);
                           
                                        ?>

                                        <tr>
                                            <td> <?=$idpesanan;?> </td>
                                            <td> <?=$tanggal;?> </td>
                                            <td> <?=$namapelanggan;?> - <?=$alamat;?> </td>
                                            <td> <?=$jumlah;?> </td>
                                            <td>
                                                <a href="view.php?idp=<?=$idpesanan;?>&tanggal=<?=$tanggal;?>" class="btn btn-primary" target="blank">View</a>  
                                                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#delete<?=$idpesanan;?>">
                                                    delete
                                                </button>
                                            </td>
                                            
                                        </tr>
                                        
                                        <!-- The Modal delete -->
                                        <div class="modal fade" id="delete<?=$idpesanan;?>">
                                            <div class="modal-dialog">
                                            <div class="modal-content">
                                            
                                                <!-- Modal Header -->
                                                <div class="modal-header">
                                                <h4 class="modal-title">Delete Data Pesanan</h4>
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                </div>
                                                

                                                <form method="post">            
                                                    <!-- Modal body -->
                                                    <div class="modal-body">
                                                        Apakah anda yakin ingin menghapus pesanan ini?
                                                        <input type="hidden" name="ido" value="<?=$idpesanan;?>">
                                                    </div>
                                                    
                                                    <!-- Modal footer -->
                                                    <div class="modal-footer">
                                                    <button type="submit" class="btn btn-success" name="hapuspesanan">Submit</button>
                                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
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
                            <div class="card mb-4">
                                <div class="card-header">
                                    <i class="fas fa-chart-bar me-1"></i>
                                    Barang Terjual Per Bulan
                                </div>
                                <div class="card-body">
                                    <canvas id="barangTerjualChart"></canvas>
                                </div>
                            </div>

                            <script>
                                var ctx = document.getElementById('barangTerjualChart').getContext('2d');
                                var myChart = new Chart(ctx, {
                                    type: 'line', // Change chart type to 'line'
                                    data: {
                                        labels: <?= json_encode($labels); ?>,
                                        datasets: [{
                                            label: 'Jumlah Barang Terjual',
                                            data: <?= json_encode($data); ?>,
                                            fill: false, // Do not fill the area under the line
                                            borderColor: 'rgba(75, 192, 192, 1)',
                                            borderWidth: 2,
                                            pointRadius: 5,
                                            pointBackgroundColor: 'rgba(75, 192, 192, 1)',
                                        }]
                                    },
                                    options: {
                                        scales: {
                                            y: {
                                                beginAtZero: true
                                            }
                                        }
                                    }
                                });
                            </script>
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
            <h4 class="modal-title">Tambah Pesanan Baru</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            

            <form method="post">            
                <!-- Modal body -->
                <div class="modal-body">
                    Pilih Pelanggan
                    <select name="idpelanggan" class="form-control">

                    <?php
                    $getpelanggan = mysqli_query($conn, "select * from pelanggan");

                    while($pl=mysqli_fetch_array($getpelanggan)){
                        $namapelanggan = $pl['namapelanggan'];
                        $idpelanggan = $pl['idpelanggan'];
                        $alamat = $pl['alamat'];

                    
                    ?>

                    <option value="<?=$idpelanggan;?>"> <?=$namapelanggan;?> - <?=$alamat;?> </option>

                    <?php
                    }
                    ?>

                    </select>
                </div>
                
                <!-- Modal footer -->
                <div class="modal-footer">
                <button type="submit" class="btn btn-success" name="tambahpesanan">Submit</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </form>

        </div>
        </div>
    </div>


</html>
