<?php

session_start();

//Bikin Koneksi
$conn = mysqli_connect('localhost:3307', 'root', '', 'cashierOtomotif');

//login
if(isset($_POST['login'])){
    //intiate variable
    $username = $_POST['username'];
    $password = $_POST['password'];

    $check = mysqli_query($conn, "SELECT * FROM user WHERE username='$username' and password='$password'");
    $hitung = mysqli_num_rows($check);

    if($hitung>0){
        //jika data berhasil ditemukan
        //login berhasil

        $_SESSION['login'] = 'true';
        header('location:index.php');
    } else {
        //jika data tidak ditemukan
        //gagal login
        echo '
        <script>alert("username atau password salah!");
        window.location.href="login.php";
        </script>
        ';

    }
}


if(isset($_POST['tambahbarang'])){
    $namaproduk = $_POST['namaproduk'];
    $deskripsi = $_POST['deskripsi'];
    $stock = $_POST['stock'];
    $harga = $_POST['harga'];

    $insert = mysqli_query($conn, "insert into produk (namaproduk,deskripsi,harga,stock) values ('$namaproduk','$deskripsi','$harga','$stock')");

    if($insert){
        header('location:stock.php');
    }else{
        echo '
        <script>alert("Gagal Menambahkan Barang Baru!");
        window.location.href="stock.php";
        </script>
        ';
    }

};

if(isset($_POST['tambahpelanggan'])){
    $namapelanggan = $_POST['namapelanggan'];
    $notelp = $_POST['notelp'];
    $alamat = $_POST['alamat'];

    $insert = mysqli_query($conn, "insert into pelanggan (namapelanggan,notelp,alamat) values ('$namapelanggan','$notelp','$alamat')");

    if($insert){
        header('location:pelanggan.php');
    }else{
        echo '
        <script>alert("Gagal Menambahkan Pelanggan Baru!");
        window.location.href="pelanggan.php";
        </script>
        ';
    }

};

if(isset($_POST['tambahpesanan'])){
    $idpelanggan = $_POST['idpelanggan'];

    $insert = mysqli_query($conn, "insert into pesanan (idpelanggan) values ('$idpelanggan')");

    if($insert){
        header('location:index.php');
    }else{
        echo '
        <script>alert("Gagal Menambahkan Pesanan Baru!");
        window.location.href="index.php";
        </script>
        ';
    }

};

//produk dipilih dipesanan
if(isset($_POST['addproduk'])){
    $idproduk = $_POST['idproduk'];
    $idp = $_POST['idp'];
    $qty = $_POST['qty']; //jumlah yang mau dikeluarkan

    //hitung stock sekarang ada berapa
    $hitung1 = mysqli_query($conn, "select * from produk where idproduk='$idproduk'");
    $hitung2 = mysqli_fetch_array($hitung1);
    $stocksekarang = $hitung2['stock']; //stock barang saat ini

    if($stocksekarang>=$qty){

        //kurangi stocknya dengan jumlah yang akan dikeluarkan
        $selisih = $stocksekarang-$qty;

        //stocknya cukup
        $insert = mysqli_query($conn, "insert into detailpesanan (idpesanan,idproduk,qty) values ('$idp', '$idproduk', '$qty')");
        $update = mysqli_query($conn, "update produk set stock='$selisih' where idproduk='$idproduk'");

        if($insert&&$update){
            header('location:view.php?idp='.$idp);
        }else{
            echo '
            <script>alert("Gagal Menambahkan Pesanan Baru!");
            window.location.href="view.php?idp='.$idp.'"
            </script>
            ';
        }
    } else {
        //stock tidak cukup
        echo '
        <script>alert("Stock Barang Tidak Cukup!");
        window.location.href="view.php?idp='.$idp.'"
        </script>
        ';
    }
};

//menambah barang masuk
if(isset($_POST['barangmasuk'])){
    $idproduk = $_POST['idproduk'];
    $qty = $_POST['qty'];

    //cari tahu stock sekarang berapa
    $caristock = mysqli_query($conn, "select * from produk where idproduk='$idproduk'");
    $caristock2 = mysqli_fetch_array($caristock);
    $stocksekarang = $caristock2['stock'];

    //hitung
    $newstock = $stocksekarang+$qty;

    $insertb = mysqli_query($conn, "insert into masuk (idproduk,qty) values ('$idproduk','$qty')");
    $updatetb = mysqli_query($conn, "update produk set stock='$newstock' where idproduk='$idproduk'");

    if($insertb&&$updatetb){
        header('location:masuk.php');
    } else {
        echo '
        <script>alert("Stock Barang Tidak Cukup!");
        window.location.href="masuk.php"
        </script>
        ';
    }
}

//hapus produk pesanan
if(isset($_POST['hapusprodukpesanan'])){
    $idp = $_POST['idp']; //iddetailpesanan
    $idpr = $_POST['idpr'];
    $idpesanan = $_POST['idpesanan'];

    //cek qty sekarang
    $cek1 = mysqli_query($conn, "select * from detailpesanan where iddetailpesanan='$idp'");
    $cek2 = mysqli_fetch_array($cek1);
    $qtysekarang = $cek2['qty'];

    //cek stock sekarang
    $cek3 = mysqli_query($conn, "select * from produk where idproduk='$idpr'");
    $cek4 = mysqli_fetch_array($cek3);
    $stocksekarang = $cek4['stock'];

    $hitung = $stocksekarang+$qtysekarang;

    $update = mysqli_query($conn, "update produk set stock='$hitung' where idproduk='$idpr'");//update stock
    $hapus = mysqli_query($conn, "delete from detailpesanan where idproduk='$idpr' and iddetailpesanan='$idp'");

    if($update&&$hapus){
        header('location:view.php?idp='.$idpesanan);
    } else {
        echo '
        <script>alert("Gagal Menghapus Barang");
        window.location.href="view.php?idp='.$idpesanan.'"
        </script>
        ';
    }

}

//function editbarang
if(isset($_POST['editbarang'])){
    $np = $_POST['namaproduk'];
    $desc = $_POST['deskripsi'];
    $harga = $_POST['harga'];
    $idp = $_POST['idp'];

    $query = mysqli_query($conn, "update produk set namaproduk= '$np', deskripsi='$desc', harga='$harga' where idproduk='$idp'");

    if($query){
        header('location:stock.php');
    } else {
        echo '
        <script>alert("Gagal Update!");
        window.location.href="stock.php"
        </script>
        ';
    }
}

//hapus barang
if(isset($_POST['hapusbarang'])){
    $idp = $_POST['idp'];

    $query = mysqli_query($conn, "delete from produk where idproduk='$idp'");

    if($query){
        header('location:stock.php');
    } else {
        echo '
        <script>alert("Gagal Hapus!");
        window.location.href="stock.php"
        </script>
        ';
    }
}


//edit pelanggan
if(isset($_POST['editpelanggan'])){
    $np = $_POST['namapelanggan'];
    $notelp = $_POST['notelp'];
    $alamat = $_POST['alamat'];
    $idpl = $_POST['idpl'];

    $query = mysqli_query($conn, "update pelanggan set namapelanggan= '$np', notelp='$notelp', alamat='$alamat' where idpelanggan='$idpl'");

    if($query){
        header('location:pelanggan.php');
    } else {
        echo '
        <script>alert("Gagal Update!");
        window.location.href="pelanggan.php"
        </script>
        ';
    }
}

//hapus pelanggan
if(isset($_POST['hapuspelanggan'])){
    $idpl = $_POST['idpl'];

    $query = mysqli_query($conn, "delete from pelanggan where idpelanggan='$idpl'");

    if($query){
        header('location:pelanggan.php');
    } else {
        echo '
        <script>alert("Gagal Hapus!");
        window.location.href="pelanggan.php"
        </script>
        ';
    }
}


//edit barang masuk
if(isset($_POST['editbarangmasuk'])){
    $qty = $_POST['qty'];
    $idm = $_POST['idm'];
    $idp = $_POST['idp'];

    //cari tahu qtynya sekarang berapa
    $caritahu = mysqli_query($conn, "select * from masuk where idmasuk='$idm'");
    $caritahu2 = mysqli_fetch_array($caritahu);
    $qtysekarang = $caritahu2['qty'];

    //cari tahu stock sekarang berapa
    $caristock = mysqli_query($conn, "select * from produk where idproduk='$idp'");
    $caristock2 = mysqli_fetch_array($caristock);
    $stocksekarang = $caristock2['stock'];

    if($qty >= $qtysekarang){
        //kalau inputan user lebih besar daripada qty yang tercatat
        //hitung selisih
        $selisih = $qty-$qtysekarang;
        $newstock = $stocksekarang+$selisih;

        $query1 = mysqli_query($conn, "update masuk set qty='$qty'where idmasuk='$idm'");
        $query2 = mysqli_query($conn, "update produk set stock='$newstock'where idproduk='$idp'");

        if($query1&&$query2){
            header('location:masuk.php');
        } else {
            echo '
            <script>alert("Gagal Update!");
            window.location.href="masuk.php"
            </script>
            ';
        }
    } else {
        //kalau lebih kecil
        $selisih = $qtysekarang-$qty;
        $newstock = $stocksekarang-$selisih;

        $query1 = mysqli_query($conn, "update masuk set qty='$qty'where idmasuk='$idm'");
        $query2 = mysqli_query($conn, "update produk set stock='$newstock'where idproduk='$idp'");

        if($query1&&$query2){
            header('location:masuk.php');
        } else {
            echo '
            <script>alert("Gagal Update!");
            window.location.href="masuk.php"
            </script>
            ';
        }
    }

}

//hapus data barang masuk
if(isset($_POST['hapusbarangmasuk'])){
    $idm = $_POST['idm'];
    $idp = $_POST['idp'];

    //cari tahu qtynya sekarang berapa
    $caritahu = mysqli_query($conn, "select * from masuk where idmasuk='$idm'");
    $caritahu2 = mysqli_fetch_array($caritahu);
    $qtysekarang = $caritahu2['qty'];

    //cari tahu stock sekarang berapa
    $caristock = mysqli_query($conn, "select * from produk where idproduk='$idp'");
    $caristock2 = mysqli_fetch_array($caristock);
    $stocksekarang = $caristock2['stock'];

    //kalau lebih kecil
    $newstock = $stocksekarang-$qtysekarang;

    $query1 = mysqli_query($conn, "delete from masuk where idmasuk='$idm'");
    $query2 = mysqli_query($conn, "update produk set stock='$newstock'where idproduk='$idp'");

    if($query1&&$query2){
        header('location:masuk.php');
    } else {
        echo '
        <script>alert("Gagal Update!");
        window.location.href="masuk.php"
        </script>
        ';
    }
}

//hapus pesanan
if(isset($_POST['hapuspesanan'])){
    $ido = $_POST['ido'];

    $cekdata = mysqli_query($conn, "select * from detailpesanan dp where idpesanan='$ido'");

    while($ok=mysqli_fetch_array($cekdata)){
        //balikin stock
        $qty = $ok['qty'];
        $idproduk = $ok['idproduk'];
        $iddp = $ok['iddetailpesanan'];

         //cari tahu stock sekarang berapa
        $caristock = mysqli_query($conn, "select * from produk where idproduk='$idproduk'");
        $caristock2 = mysqli_fetch_array($caristock);
        $stocksekarang = $caristock2['stock'];

        $newstock = $stocksekarang+$qty;

        $queryupdate = mysqli_query($conn, "update produk set stock='$newstock'where idproduk='$idproduk'");

        //hapus data
        $querydelete = mysqli_query($conn, "delete from detailpesanan where iddetailpesanan='$iddp'");
        //redirect
    }

    $query = mysqli_query($conn, "delete from pesanan where idpesanan='$ido'");

    if($queryupdate && $querydelete && $query){
        header('location:index.php');
    } else {
        echo '
        <script>alert("Gagal Hapus!");
        window.location.href="index.php"
        </script>
        ';
    }
}

//mengubah data detail pesanan
if(isset($_POST['editdetailpesanan'])){
    $qty = $_POST['qty'];
    $iddp = $_POST['iddp'];
    $idpr = $_POST['idpr'];
    $idp = $_POST['idp'];

    //cari tahu qtynya sekarang berapa
    $caritahu = mysqli_query($conn, "select * from detailpesanan where iddetailpesanan='$iddp'");
    $caritahu2 = mysqli_fetch_array($caritahu);
    $qtysekarang = $caritahu2['qty'];

    //cari tahu stock sekarang berapa
    $caristock = mysqli_query($conn, "select * from produk where idproduk='$idpr'");
    $caristock2 = mysqli_fetch_array($caristock);
    $stocksekarang = $caristock2['stock'];

    if($qty >= $qtysekarang){
        //kalau inputan user lebih besar daripada qty yang tercatat
        //hitung selisih
        $selisih = $qty-$qtysekarang;
        $newstock = $stocksekarang-$selisih;

        $query1 = mysqli_query($conn, "update detailpesanan set qty='$qty'where iddetailpesanan='$iddp'");
        $query2 = mysqli_query($conn, "update produk set stock='$newstock'where idproduk='$idpr'");

        if($query1&&$query2){
            header('location:view.php?idp='.$idp);
        } else {
            echo '
            <script>alert("Gagal Update!");
            window.location.href="view.php?='.$idp.'"
            </script>
            ';
        }
    } else {
        //kalau lebih kecil
        $selisih = $qtysekarang-$qty;
        $newstock = $stocksekarang+$selisih;

        $query1 = mysqli_query($conn, "update detailpesanan set qty='$qty'where iddetailpesanan='$iddp'");
        $query2 = mysqli_query($conn, "update produk set stock='$newstock'where idproduk='$idpr'");

        if($query1&&$query2){
            header('location:view.php?idp='.$idp);
        } else {
            echo '
            <script>alert("Gagal Update!");
            window.location.href="view.php?idp='.$idp.'"
            </script>
            ';
        }
    }

}
?>