<?php
require 'ceklogin.php';

//hitung jumlah barang
$h1 = mysqli_query($conn, "select * from produk");
$h2 = mysqli_num_rows($h1);
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Stock Barang</title>
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
                                <div class="sb-nav-link-icon"><i class="fas fa-shopping-cart"></i></div>
                                Order
                            </a>
                            <a class="nav-link" href="stock.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-archive" ></i></div>
                                Stock Barang
                            </a>
                            <a class="nav-link" href="masuk.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-cubes"></i></div>
                                Barang Masuk
                            </a>
                            <a class="nav-link" href="pelanggan.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-user-friends" style="color:yellow"></i></div>
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
                        <h1 class="mt-4 mb-3">Import Excel Pelanggan</h1>
                        <div style="margin:auto;width: 600px;padding: 20px;">
                            <form action="" method="POST" enctype="multipart/form-data" class="row g-2">
                                <div class="col-auto">
                                    <input type="file" class="form-control" name="excel" id="formFile">
                                </div>
                                <div class="col-auto">
                                    <input type="submit" name="import" class="btn btn-primary" value="Upload File XLS/XLSX">
                                </div>
                                <a href="pelangganFormat.xlsx">Download Format</a>
                            </form>
                            <hr>
                            <table id="datatablesSimple">
                                <tr>
                                    <td>No</td>
                                    <td>Nama Pelanggan</td>
                                    <td>No Telp</td>
                                    <td>Alamat</td>
                                </tr>
                                <?php
                                $i = 1;
                                $rows = mysqli_query($conn, "SELECT * FROM pelanggan");
                                foreach($rows as $row) :
                                ?>
                                <tr>
                                    <td> <?php echo $i++; ?> </td>
                                    <td> <?php echo $row["namapelanggan"]; ?> </td>
                                    <td> <?php echo $row["notelp"]; ?> </td>
                                    <td> <?php echo $row["alamat"]; ?> </td>
                                </tr>
                                <?php endforeach; ?>
                            </table>
                            <?php
                            if(isset($_POST["import"])){
                                $fileName = $_FILES["excel"]["name"];
                                $fileExtension = explode('.', $fileName);
                        $fileExtension = strtolower(end($fileExtension));
                                $newFileName = date("Y.m.d") . " - " . date("h.i.sa") . "." . $fileExtension;

                                $targetDirectory = "uploads/" . $newFileName;
                                move_uploaded_file($_FILES['excel']['tmp_name'], $targetDirectory);

                                error_reporting(0);
                                ini_set('display_errors', 0);

                                require 'excelReader/excel_reader2.php';
                                require 'excelReader/SpreadsheetReader.php';

                                $reader = new SpreadsheetReader($targetDirectory);
                                // Mulai dari baris kedua (indeks 1)
                                $skipFirstRow = true;
                                foreach($reader as $key => $row){
                                    // Skip baris pertama (header)
                                    if ($skipFirstRow) {
                                        $skipFirstRow = false;
                                        continue;
                                    }

                                    $namapelanggan = $row[0];
                                    $notelp = $row[1];
                                    $alamat = $row[2];
                                    mysqli_query($conn, "INSERT INTO pelanggan VALUES('', '$namapelanggan', '$notelp', '$alamat')");
                                }

                                echo
                                "
                                <script>
                                alert('Succesfully Imported');
                                document.location.href = '';
                                </script>
                                ";
                            }
                            ?>
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
            <h4 class="modal-title">Tambah Barang Baru</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            

            <form method="post">            
                <!-- Modal body -->
                <div class="modal-body">
                    <input type="text" name="namaproduk" class="form-control" placeholder="Nama Produk">
                    <input type="text" name="deskripsi" class="form-control mt-2" placeholder="Deskripsi">
                    <input type="num" name="stock" class="form-control mt-2" placeholder="Stock Awal">
                    <input type="num" name="harga" class="form-control mt-2" placeholder="Harga Produk">
                </div>
                
                <!-- Modal footer -->
                <div class="modal-footer">
                <button type="submit" class="btn btn-success" name="tambahbarang">Submit</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </form>

        </div>
        </div>
    </div>


</html>
