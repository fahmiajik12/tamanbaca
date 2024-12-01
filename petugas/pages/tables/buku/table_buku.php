<?php
include '../../../../helper/connection.php';
?>

<?php 
session_start();
if(!$_SESSION['username'] && !$_SESSION['password'] && $_SESSION['tipe_user'] != "Petugas")
{
    echo "
		<script type='text/javascript'>
		alert('Anda harus login terlebih dahulu!')
		window.location='../admin/index.php';
		</script>";
}
else
{
?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/css/bootstrap.min.css"  integrity="sha384-DhY6onE6f3zzKbjUPRc2hOzGAdEf4/Dz+WJwBvEYL/lkkIsI3ihufq9hk9K4lVoK" crossorigin="anonymous"/>
    <!-- Bootstrap CSS -->   
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <!-- <link rel="stylesheet" type="text/css" href="dashboard.css"> -->
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <title>Petugas-Buku</title>
    <style>
        .sidebar {
            width: 250px;
            height: 100vh;
            position: fixed;
            margin-left: -300px;
            transition: 0.4s;
        }

        .active-main-content {
            margin-left: 250px;
        }

       .active-sidebar {
            margin-left: 0;
        }
        
        .sidebar a.nav-link:not(:last-child) {
            margin-bottom: 5px;
        }

        #main-content {
            transition: 0.4s;
        }

        .lgout{
            color:#ffffff;
        }

        .fixed-footer {
            width: 100%;
            position: static;
            margin: 0 10px 10px 0;
            padding: 10px 0;
            color: rgba(255, 255, 255, 1);
            text-align: center;
            bottom:0;
        }
    </style>
</head>

<body>
    <!-- navbar -->
    <nav class="navbar navbar-dark bg-dark" width="10px">
        <span class="navbar-brand mb-0 h1">Taman Baca Kesiman</span>
        <a href="../../../../admin/process/logout.php" class="btn btn-danger mr-3">Logout</a>                             
    </nav>
    <!-- sidebar -->
    <div class="sidebar p-4 bg-dark" id="sidebar">
        <a class="btn btn-light text-black nav-link" href="../../../dashboard.php"><h5><b>Dashboard</b></h5></a><hr>
        <a class="btn btn-light text-black nav-link" href="table_buku.php">Data Buku</a>

        <a class="btn btn-light text-black nav-link" href="../kategori/table_kategori.php">Data Kategori</a>
        <a class="btn btn-light text-black nav-link" href="../penerbit/table_penerbit.php">Data Penerbit</a>
        <a class="btn btn-light text-black nav-link" href="../pengarang/table_pengarang.php">Data Pengarang</a>
        <a class="btn btn-light text-black nav-link" href="../transaksi/table_transaksi.php">Data Transaksi</a>

    </div>
    <div class="p-4" id="main-content">
        <button class="btn btn-dark" id="button-toggle">
        <i class="tgle">Lihat Menu</i>
        </button>
        <div class="card mt-3">
            <div class="container-fluid dashboard-content ">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <h2>Buku</h2>
                    <div class="page-breadcrumb">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Tabel</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Data Buku</li>
                            </ol>
                        </nav>
                    </div>
                </div>

                <div class="col-xl-12">
                    <a href="form_buku.php" class="btn btn-primary">Tambah Data</a>
                    <?php
                    $message = '';
                    if(isset($_GET["error"]))
                    {
                        $message = $_GET["error"];
                        echo "<br><br>
                        <p style='color:red; font-style:italic'>$message</p>";
                    }
                    ?>
                    <br><br>
                    <table id="tabell" class="table table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>ID Buku</th>
                                <th>Judul</th>
                                <th>Pengarang</th>
                                <th>Penerbit</th>
                                <th>Stok</th>
                                <th>Gambar</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $query = 
                                "SELECT b.id_buku,b.judul_buku,pg.nama_pengarang,pn.nama_penerbit,b.stok,b.gambar,b.deleted from buku b,pengarang pg,penerbit pn WHERE b.id_pengarang = pg.id_pengarang 
                                AND
                                b.id_penerbit = pn.id_penerbit
                                AND
                                b.deleted = 0 ORDER BY b.id_buku";
                                
                                $result = mysqli_query($con, $query);

                                if (mysqli_num_rows($result) > 0)
                                {
                                    $index = 1;

                                    while($row = mysqli_fetch_assoc($result))
                                    {
                                        $id_buku = $row['id_buku'];
                                        echo "
                                        <tr>
                                            <td>" . $index++ . "</td>
                                            <td>" . $row["id_buku"] . "</td>
                                            <td>" . $row["judul_buku"] . "</td>
                                            <td>" . $row["nama_pengarang"] . "</td>
                                            <td>" . $row["nama_penerbit"] . "</td>
                                            <td>" . $row["stok"] . "</td>
                                            <td><img src='../../../../images/". $row["gambar"] ."' width='200px'></td>
                                            <td>
                                                <a href='form_edit_buku.php?id_buku=$id_buku' class='btn btn-warning'>Update</a>
                                                <a href='process/delete_buku.php?id_buku=$id_buku' class='btn btn-danger'>Delete</a>
                                            </td>
                                        </tr>
                                        ";
                                    }
                                }

                                mysqli_close($con);
                                ?>
                        </tbody>
                    </table>
                </div>
            </div> 
        </div>
    </div>
        
        
    <!-- footer -->
    <div class="fixed-footer bg-dark">
      <div class="container">Copyright &copy; 2024 &copy; Siti Khoirun Nisa &copy; 2225240072 &copy; TUGAS UAS ALPRO</div>
    </div>


         
    <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>

    <script>
    
    // event will be executed when the toggle-button is clicked
    document.getElementById("button-toggle").addEventListener("click", () => {

      // when the button-toggle is clicked, it will add/remove the active-sidebar class
      document.getElementById("sidebar").classList.toggle("active-sidebar");

      // when the button-toggle is clicked, it will add/remove the active-main-content class
      document.getElementById("main-content").classList.toggle("active-main-content");
    });

    </script>
    
    <script>
        $(document).ready(function () {
            $('#tabell').DataTable();
        });
    </script>
</body>

</html>

<?php } ?>