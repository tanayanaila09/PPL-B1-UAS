<?php 
// menghubungkan file functions dengan index

$conn = mysqli_connect("localhost", "root", "", "kres.co");

if(mysqli_connect_error()){
    echo "Koneksi gagal : " .mysqli_connect_error();
}
?>