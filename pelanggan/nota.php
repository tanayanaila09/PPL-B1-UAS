<?php 
session_start();
include '../koneksi.php';
$ui = $_SESSION['id_pelanggan'];
$cari = mysqli_query($conn, "select * from keranjang where id_pelanggan='$ui' and status = 'order'");
$fetc = mysqli_fetch_array($cari);

if (empty($fetc['id_ongkir']) or !isset($fetc['id_ongkir'])) {

    echo "<script>alert('Harap isi semua data!')</script>";
    echo "<script>location='index.php'</script>";
}

if (isset($_POST["buat"])) {
    $q3 = mysqli_query($conn,"update keranjang set status='bayar' where orderid= '".$fetc['orderid']."'");
    if ($q3) {
            echo "berhasil melakukan pemesanan
            <meta http-equiv='refresh' content='1; url= pemesanan.php' />";
    }else {
        echo "gagal melakukan pemesanan
        <meta http-equiv='refresh' content='1; url= keranjang.php' />";
    }
}else {
    
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.88.1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <!-- Google font-->
    <link href="https://fonts.googleapis.com/css?family=Ubuntu:400,500,700" rel="stylesheet">

    <!-- themify -->
    <link rel="stylesheet" type="text/css" href="../Assets/icon/themify-icons/themify-icons.css">

    <!-- iconfont -->
    <link rel="stylesheet" type="text/css" href="../Assets/icon/icofont/css/icofont.css">

    <!-- simple line icon -->
    <link rel="stylesheet" type="text/css" href="../Assets/icon/simple-line-icons/css/simple-line-icons.css">

    <!-- Required Fremwork -->
    <link rel="stylesheet" type="text/css" href="../Assets/plugins/bootstrap/css/bootstrap.min.css">

    <!-- Chartlist chart css -->
    <link rel="stylesheet" href="../Assets/plugins/chartist/dist/chartist.css" type="text/css" media="all">

    <!-- Weather css -->
    <link href="../Assets/css/svg-weather.css" rel="stylesheet">

    <!-- Style.css -->
    <link rel="stylesheet" type="text/css" href="../Assets/css/main.css">

    <!-- Responsive.css-->
    <link rel="stylesheet" type="text/css" href="../Assets/css/responsive.css">

    <!-- Custom styles for this template -->
    <link href="../Assets/css/sidebars.css" rel="stylesheet">
    
    <title>Nota</title>
</head>

<body class="sidebar-mini fixed">
    <div class="loader-bg">
        <div class="loader-bar"></div>
    </div>
    <div class="wrapper">
        <!-- Navbar-->
        <header class="main-header-top hidden-print">
            <a href="index.php" class="logo"><b>Kres.co PELANGGAN</b></a>
            <nav class="navbar navbar-static-top">
                <!-- Sidebar toggle button-->
                <a href="#!" data-toggle="offcanvas" class="sidebar-toggle"></a>

                <!-- Navbar Right Menu-->
                <div class="navbar-custom-menu f-right">
                    <ul class="top-nav">
                        <!-- User Menu-->
                        <li class="dropdown" style="padding-left: 800px;">
                            <a href="profil.php" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" class="dropdown-toggle drop icon-circle drop-image">
                                <span><img class="img-circle " src="../Assets/images/avatar-1.png" style="width:40px;" alt="User Image"></span>
                                <span>
                                    <?php
                                    $no = 1;
                                    $sql = $conn->query("SELECT * FROM pelanggan WHERE username ='$_SESSION[username]'");
                                    while ($data = $sql->fetch_assoc()) {
                                    ?>
                                        <b><?php echo $data['username'] ?></b> <?php  } ?>
                                    <i class=" icofont icofont-simple-down"></i></span>
                            </a>
                            <ul class="dropdown-menu settings-menu">
                                <a style="text-decoration: none; color: black;" href="profil.php">
                                    <li><i class="icon-user"></i> Profil</li>
                                </a>
                                <a style="text-decoration: none; color: black;" href="../logout.php">
                                    <li><i class="icon-logout"></i> Keluar</li>
                                </a>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>

        <!-- Side-Nav-->
        <aside class="main-sidebar hidden-print">
            <section class="sidebar" id="sidebar-scroll">
                <!-- Sidebar Menu-->
                <ul class="sidebar-menu">
                    <li class="nav-level"></li>
                    <li class="active treeview">
                        <a class="waves-effect waves-dark" href="index.php">
                            <i class="icon-speedometer"></i><span> Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-level"></li>
                    <li class="active treeview">
                        <a class="waves-effect waves-dark" href="keranjang.php">
                            <i class="icon-briefcase"></i><span> Keranjang</span>
                        </a>
                    </li>
                    <li class="nav-level"></li>
                    <li class="active treeview">
                        <a class="waves-effect waves-dark" href="pemesanan.php">
                            <i class="icon-briefcase"></i><span> Pesanan Saya</span>
                        </a>                
                    </li>


                    </li>
                </ul>
            </section>
        </aside>

        <!-- konten -->
        <form method="POST">
        <div class="content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="main-header">
                        <h4>Nota</h4>

                        <table class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Barang</th>
                            <th>Ukuran/Varian</th>
                            <th>Harga</th>
                            <th>Jumlah</th>
                            <th>Subharga</th>
                        </tr>
                    </thead>
                    
                    <tbody>
                        <?php $i = 1; ?>
                            <!-- Menampilkan barang yang sedang diperulangkan berdasarkan id_barang -->
                            <?php
                            $i = 1;
                            $brg = mysqli_query($conn,"select * from ongkir o, detail d, barang b where  o.id_ongkir = '".$fetc['id_ongkir']."' and d.orderid= '".$fetc['orderid']."'  and  b.id_barang=d.id_barang");
                            $totalbelanja = 0;
                            $tarif = 0;
                            while($pecah=mysqli_fetch_array($brg)){
                                $hrg = $pecah['harga'];
						        $qwe = $pecah['qwe'];
                                $tarif = $pecah['tarif'];
                                $subharga = $pecah['harga'] * $pecah['qwe'];
                                $totalbelanja += $subharga;
                                

                            ?>
                            <tr>
                                <td><?= $i++; ?></td>
                                <td><?= $pecah['nama_barang']; ?></td>
                                <td><?= $pecah['ukuran']; ?></td>
                                <td>Rp. <?= number_format($pecah['harga']); ?></td>
                                <td><?= number_format($pecah['qwe']); ?></td>
                                <td>Rp. <?= number_format($subharga) ; ?></td>
                            </tr>
                <?php
						}
					?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="5">Total Belanja</th>
                            <th>Rp. <?= number_format($totalbelanja); ?></th>
                        </tr>
                        <tr>
                            <th colspan="5">Ongkir</th>
                            <th>Rp. <?= number_format($tarif); ?></th>
                        </tr>
                        <tr>
                            <th colspan="5">Total yang harus dibayar</th>
                            <th>Rp. <?= number_format($tarif+$totalbelanja); ?></th>
                        </tr>
                    </tfoot>
                    </table>
                    <div>
                        <div style="padding-left: 5px;">
                    </div>
                        <button type="submit" class="btn btn-primary" name="buat">Buat Pesanan</button>
                    </form>
                </div>
            </div>
        </div>



    <!-- Required Jqurey -->
    <script src="../Assets/plugins/Jquery/dist/jquery.min.js"></script>
        <script src="../Assets/plugins/jquery-ui/jquery-ui.min.js"></script>
        <script src="../Assets/plugins/tether/dist/js/tether.min.js"></script>

        <!-- Required Fremwork -->
        <script src="../Assets/plugins/bootstrap/js/bootstrap.min.js"></script>

        <!-- Scrollbar JS-->
        <script src="../Assets/plugins/jquery-slimscroll/jquery.slimscroll.js"></script>
        <script src="../Assets/plugins/jquery.nicescroll/jquery.nicescroll.min.js"></script>

        <!--classic JS-->
        <script src="../Assets/plugins/classie/classie.js"></script>

        <!-- notification -->
        <script src="../Assets/plugins/notification/js/bootstrap-growl.min.js"></script>

        <!-- Sparkline charts -->
        <script src="../Assets/plugins/jquery-sparkline/dist/jquery.sparkline.js"></script>

        <!-- Counter js  -->
        <script src="../Assets/plugins/waypoints/jquery.waypoints.min.js"></script>
        <script src="../Assets/plugins/countdown/js/jquery.counterup.js"></script>

        <!-- Echart js -->
        <script src="../Assets/plugins/charts/echarts/js/echarts-all.js"></script>

        <script src="https://code.highcharts.com/highcharts.js"></script>
        <script src="https://code.highcharts.com/modules/exporting.js"></script>
        <script src="https://code.highcharts.com/highcharts-3d.js"></script>

        <!-- custom js -->
        <script type="text/javascript" src="../Assets/js/main.min.js"></script>
        <script type="text/javascript" src="../Assets/pages/dashboard.js"></script>
        <script type="text/javascript" src="../Assets/pages/elements.js"></script>
        <script src="../Assets/js/menu.min.js"></script>
        <script>
            var $window = $(window);
            var nav = $('.fixed-button');
            $window.scroll(function() {
                if ($window.scrollTop() >= 200) {
                    nav.addClass('active');
                } else {
                    nav.removeClass('active');
                }
            });
        </script>
    
</body>
</html>