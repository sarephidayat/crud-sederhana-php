<?php
session_start();

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['session_username'])) {
    header('Location: login.php');
    exit;
}

// koneksikan ke database
$koneksi = mysqli_connect("localhost", "root", "", "sekolah");
if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

$sukses = "";
$gagal = "";

// Delete data
if (isset($_GET['op']) && $_GET['op'] == 'delete') {
    $id = $_GET['id'];
    $query = mysqli_query($koneksi, "DELETE FROM guru WHERE id = '$id'");
    if ($query) {
        header('location: index.php');
    } else {
        $gagal = "Data gagal dihapus";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        .mx-auto {
            width: 800px;
        }

        .card {
            margin: 10px;
        }
    </style>
</head>

<body>
    <div class="mx-auto">
        <!-- Tombol Logout -->
        <div class="d-flex justify-content-end my-3">
            <a href="logout.php" class="btn btn-danger">Logout</a>
        </div>

        <!-- untuk menampilkan pesan sukses atau gagal -->
        <?php if ($sukses) { ?>
            <div class="alert alert-success" role="alert">
                <?php echo $sukses ?>
            </div>
        <?php } ?>

        <?php if ($gagal) { ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $gagal ?>
            </div>
        <?php } ?>

        <!-- untuk read -->
        <div class="card">
            <div class="card-header">
                Tampilan Data
            </div>
            <div class="card-body">
                <a href="create.php" class="btn btn-primary mb-3">Tambah Data</a>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">NAMA</th>
                            <th scope="col">NIP</th>
                            <th scope="col">PELAJARAN</th>
                            <th scope="col">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // menampilkan data
                        $result = mysqli_query($koneksi, "SELECT * FROM guru ORDER BY id DESC");
                        $urut = 1;

                        while ($r2 = mysqli_fetch_array($result)) {
                            $id = $r2['id'];
                            $nama = $r2['nama'];
                            $nip = $r2['nip'];
                            $pelajaran = $r2['pelajaran'];
                            ?>
                            <tr>
                                <th scope="row"><?php echo $urut++ ?></th>
                                <td><?php echo $nama ?></td>
                                <td><?php echo $nip ?></td>
                                <td><?php echo $pelajaran ?></td>
                                <td>
                                    <a href="edit.php?id=<?php echo $id ?>">
                                        <button type="button" class="btn btn-warning">Edit</button>
                                    </a>
                                    <a href="index.php?op=delete&id=<?php echo $id ?>"
                                        onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                        <button type="button" class="btn btn-danger">Hapus</button>
                                    </a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
</body>

</html>