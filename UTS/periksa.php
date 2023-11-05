<?php

include 'conpoli.php';

if (!isset($_SESSION['username'])) {
    header("Location: index.php");
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, 
    initial-scale=1.0">

    <!-- Bootstrap offline sesuai lokasi file disimpan -->
    <link rel="stylesheet" href="assets/css/bootstrap.css"> 

    <!-- Bootstrap Online -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC"
    crossorigin="anonymous">   <!-- Gunakan salah satu cara saja -->

    <!-- Load JS online -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>   
    <!-- cukup gunakan salah satu saja -->
    
    <title>Poliklinik</title>   <!--Judul Halaman-->
</head>
<body>
        <form method="POST" action="" name="myForm" onsubmit="return(validate());">
            <!-- Kode php untuk menghubungkan form dengan database -->
            <?php
            $id_pasien = '';
            $id_dokter = '';
            $tgl_periksa = '';
            $obat ='';
            $catatan = '';
            if (isset($_GET['id'])) {
                $ambil = mysqli_query($mysqli, "SELECT * FROM periksa WHERE id='" . $_GET['id'] . "'");
                while ($row = mysqli_fetch_array($ambil)) {
                    $id_pasien = $row['id_pasien'];
                    $id_dokter = $row['id_dokter'];
                    $tgl_periksa = $row['tgl_periksa'];
                    $obat = $row['obat'];
                    $catatan = $row['catatan'];
                }
            ?>
                <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>">
            <?php
            }
            ?>


          <div class="form-group mx-sm-3 mb-2">
                <label for="inputPasien" class="sr-only">Pasien</label>
                <select class="form-control" name="id_pasien">
                    <?php
                    $selected = '';
                    $pasien = mysqli_query($mysqli, "SELECT * FROM pasien");
                    while ($data = mysqli_fetch_array($pasien)) {
                        if ($data['id'] == $id_pasien) {
                            $selected = 'selected="selected"';
                        } else {
                            $selected = '';
                        }
                    ?>
                        <option value="<?php echo $data['id'] ?>" <?php echo $selected ?>><?php echo $data['nama'] ?></option>
                    <?php
                    }
                    ?>
                </select>
            </div>
            <div class="form-group mx-sm-3 mb-2">
                <label for="inputDokter" class="sr-only">Dokter</label>
                <select class="form-control" name="id_dokter">
                    <?php
                    $selected = '';
                    $dokter = mysqli_query($mysqli, "SELECT * FROM dokter");
                    while ($data = mysqli_fetch_array($dokter)) {
                        if ($data['id'] == $id_dokter) {
                            $selected = 'selected="selected"';
                        } else {
                            $selected = '';
                        }
                    ?>
                        <option value='<?php echo $data['id'] ?>' <?php echo $selected ?>><?php echo $data['nama'] ?></option>
                    <?php
                    }
                    ?>
                </select>
            </div>

            <div class="form-group mx-sm-3 mb-2">
              <label for="inputTanggal" class="sr-only">Tanggal Periksa</label>
              <input type="datetime-local" class="form-control" name="tgl_periksa" id="inputTanggalAkhir" value="<?php echo $tgl_periksa?>">
            </div>

            <div class="form-group mx-sm-3 mb-2">
              <label for="obat" class="sr-only">Obat</label>
              <input type="text" class="form-control" name="obat" id="obat" value="<?php echo $obat?>">
            </div>

            <div class="form-group mx-sm-3 mb-2">
              <label for="inputTanggal" class="sr-only">Catatan</label>
              <input type="text" class="form-control" name="catatan" id="catatan" value="<?php echo $catatan?>">
            </div>


            <div class="form-group mx-sm-3 mb-2">
              <button type="submit" class="btn btn-primary rounded-pill px-3" name="simpan">Simpan</button>
            </div>
        </form>

                <!-- Table-->
        <table class="table table-hover">
            <!--thead atau baris judul-->
            <thead>
                <tr>
                    <th scope="col">Id</th>
                    <th scope="col">Nama Pasien</th>
                    <th scope="col">Nama Dokter</th>
                    <th scope="col">Tanggal Periksa</th>
                    <th scope="col">Obat</th>
                    <th scope="col">Catatan</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>
            <!--tbody berisi isi tabel sesuai dengan judul atau head-->
            <tbody>
                <!-- Kode PHP untuk menampilkan semua isi dari tabel urut
                berdasarkan status dan tanggal awal-->
                <?php
                $result = mysqli_query($mysqli, "SELECT pr.*,d.nama as 'nama_dokter', p.nama as 'nama_pasien' FROM periksa pr LEFT JOIN dokter d ON (pr.id_dokter=d.id) LEFT JOIN pasien p ON (pr.id_pasien=p.id) ORDER BY pr.tgl_periksa DESC");
                $no = 1;
                while ($data = mysqli_fetch_array($result)) {
                ?>
                    <tr>
                        <td><?php echo $no++ ?></td>
                        <td><?php echo $data['nama_pasien'] ?></td>
                        <td><?php echo $data['nama_dokter'] ?></td>
                        <td><?php echo $data['tgl_periksa'] ?></td>
                        <td><?php echo $data['obat'] ?></td>
                        <td><?php echo $data['catatan'] ?></td>
                        <td>
                            <a class="btn btn-success rounded-pill px-3" 
                            href="home.php?page=periksa&id=<?php echo $data['id'] ?>">
                            Ubah</a>
                            <a class="btn btn-danger rounded-pill px-3" 
                            href="home.php?page=periksa&id=<?php echo $data['id'] ?>&aksi=hapus">Hapus</a>
                        </td>
                    </tr>
                <?php
                }
                ?>
                                           
            <?php
                if (isset($_POST['simpan'])) {
                    if (isset($_POST['id'])) {
                        $ubah = mysqli_query($mysqli, "UPDATE periksa SET 
                                                        id_pasien = '" . $_POST['id_pasien'] . "',
                                                        id_dokter = '" . $_POST["id_dokter"] . "',
                                                        tgl_periksa = '" . $_POST['tgl_periksa'] . "',
                                                        obat = '" . $_POST['obat'] . "',
                                                        catatan = '" . $_POST['catatan'] . "'
                                                        WHERE
                                                        id = '" . $_POST['id'] . "'");
                    } else {
                        $tambah = mysqli_query($mysqli, "INSERT INTO periksa(id_pasien,id_dokter,tgl_periksa,obat,catatan) 
                                                        VALUES ( 
                                                            '" . $_POST['id_pasien'] . "',
                                                            '" . $_POST['id_dokter'] . "',
                                                            '" . $_POST['tgl_periksa'] . "',
                                                            '" . $_POST['obat'] . "',
                                                            '" . $_POST['catatan'] . "'
                                                            )");
                    }

                    echo "<script> 
                            document.location='home.php?page=periksa';
                            </script>";
                }

                if (isset($_GET['aksi'])) {
                    if ($_GET['aksi'] == 'hapus') {
                        $hapus = mysqli_query($mysqli, "DELETE FROM periksa WHERE id = '" . $_GET['id'] . "'");
                    }

                    echo "<script> 
                            document.location='home.php?page=periksa';
                            </script>";
                }
                ?>

    </div>
</body>
</html>