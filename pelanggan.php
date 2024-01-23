<?php
require 'ceklogin.php';
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Data Pelanggan</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous" />
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
        <link href="https://fonts.googleapis.com/css2?family=Trade+Winds&display=swap" rel="stylesheet">

    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-primary">
            <!-- Navbar Brand-->
            <a class="navbar-brand ps-3 custom-font" href="index.php">MALSKITCHEN</a>
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
                                DASHBOARD
                            </a>
                            <a class="nav-link" href="index.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-shopping-cart"></i></div>
                                ORDER
                            </a>
                            <a class="nav-link" href="stock.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-archive"></i></div>
                                FOOD STOCK
                            </a>
                            <a class="nav-link" href="masuk.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-cubes"></i></div>
                                STOCK IN
                            </a>
                            <a class="nav-link" href="pelanggan.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-user-friends"style="color:black"></i></div>
                                CUSTOMER
                            </a>
                            <a class="nav-link" href="logout.php">
                                <div class="sb-nav-link-icon"><i class="fa fa-sign-out" style="color:red"></i></div>
                                LOGOUT
                            </a>
                        </div>
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4 mb-3">CUSTOMER DATA</h1>
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-receipt me-1"></i>
                                ADD CUSTOMER
                            </div>
                            <div class="card-body">
                                <!-- Button to Open the Modal -->
                                <button type="button" class="btn btn-info mb-2" data-toggle="modal" data-target="#myModal">
                                    Add Customer
                                </button>
                                <button type="button" class="btn btn-success mb-2" onclick="exportToExcel()">
                                    Export To Excel
                                </button>
                                <script>
                                    function exportToExcel() {
                                        // Mengarahkan ke prosesexportstock.php
                                        window.location.href = 'prosesexportpelanggan.php';
                                    }
                                </script>
                                <button type="button" class="btn btn-warning mb-2" onclick="importToExcel()">
                                    Import To Excel
                                </button>
                                <script>
                                    function importToExcel() {
                                        window.location.href = 'importpelanggan.php';
                                    }
                                </script>
                            </div>
                        </div>

                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                Customer Data
                            </div>
                            <div class="card-body">
                                <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Customer Name</th>
                                            <th>Telephone Number</th>
                                            <th>Address</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $get = mysqli_query($conn, "select * from pelanggan");
                                            $i = 1;

                                            while($p=mysqli_fetch_array($get)){
                                            $namapelanggan = $p['namapelanggan'];
                                            $notelp = $p['notelp'];
                                            $alamat = $p['alamat'];
                                            $idpl = $p['idpelanggan'];
                           
                                        ?>

                                        <tr>
                                            <td> <?=$i++;?> </td>
                                            <td> <?=$namapelanggan;?> </td>
                                            <td> <?=$notelp;?> </td>
                                            <td> <?=$alamat;?> </td>
                                            <td>
                                                <button type="button" class="btn btn-warning mb-3" data-toggle="modal" data-target="#edit<?=$idpl;?>">
                                                    edit
                                                </button>
                                                <button type="button" class="btn btn-danger mb-3" data-toggle="modal" data-target="#delete<?=$idpl;?>">
                                                    delete
                                                </button>
                                            </td>
                                        </tr>

                                        <!-- The Modal Edit -->
                                        <div class="modal fade" id="edit<?=$idpl;?>">
                                            <div class="modal-dialog">
                                            <div class="modal-content">
                                            
                                                <!-- Modal Header -->
                                                <div class="modal-header">
                                                <h4 class="modal-title">Edit <?=$namapelanggan;?></h4>
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                </div>
                                                

                                                <form method="post">            
                                                    <!-- Modal body -->
                                                    <div class="modal-body">
                                                        <input type="text" name="namapelanggan" class="form-control" placeholder="Customer Name" value="<?=$namapelanggan;?>">
                                                        <input type="text" name="notelp" class="form-control mt-2" placeholder="Telephone Number" value="<?=$notelp;?>">
                                                        <input type="text" name="alamat" class="form-control mt-2" placeholder="Address" value="<?=$alamat;?>">
                                                        <input type="hidden" name="idpl" value="<?=$idpl;?>">
                                                    </div>
                                                    
                                                    <!-- Modal footer -->
                                                    <div class="modal-footer">
                                                    <button type="submit" class="btn btn-success" name="editpelanggan">Submit</button>
                                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                    </div>
                                                </form>

                                            </div>
                                            </div>
                                        </div>


                                        <!-- The Modal delete -->
                                        <div class="modal fade" id="delete<?=$idpl;?>">
                                            <div class="modal-dialog">
                                            <div class="modal-content">
                                            
                                                <!-- Modal Header -->
                                                <div class="modal-header">
                                                <h4 class="modal-title">Delete <?=$namapelanggan;?></h4>
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                </div>
                                                

                                                <form method="post">            
                                                    <!-- Modal body -->
                                                    <div class="modal-body">
                                                        Are you sure you want to delete this customer ?
                                                        <input type="hidden" name="idpl" value="<?=$idpl;?>">
                                                    </div>
                                                    
                                                    <!-- Modal footer -->
                                                    <div class="modal-footer">
                                                    <button type="submit" class="btn btn-success" name="hapuspelanggan">Submit</button>
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
            <h4 class="modal-title">Add Customer Data</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            

            <form method="post">            
                <!-- Modal body -->
                <div class="modal-body">
                    <input type="text" name="namapelanggan" class="form-control" placeholder="Customer Name">
                    <input type="text" name="notelp" class="form-control mt-2" placeholder="Telephone Number">
                    <input type="text" name="alamat" class="form-control mt-2" placeholder="Address">
                </div>
                
                <!-- Modal footer -->
                <div class="modal-footer">
                <button type="submit" class="btn btn-success" name="tambahpelanggan">Submit</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </form>

        </div>
        </div>
    </div>


</html>
