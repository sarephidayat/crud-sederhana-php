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

$nama = "";
$nip = "";
$pelajaran = "";
$sukses = "";
$gagal = "";

if (isset($_POST['submit'])) {
    $nama = $_POST['nama'];
    $nip = $_POST['nip'];
    $pelajaran = $_POST['pelajaran'];

    if ($nama && $nip && $pelajaran) {
        $query = mysqli_query($koneksi, "INSERT INTO guru(nama, nip, pelajaran) VALUES ('$nama', '$nip', '$pelajaran')");
        if ($query) {
            header('Location: index.php');
            exit;
        } else {
            $gagal = "Data gagal ditambahkan";
        }
    } else {
        $gagal = "Isi data terlebih dahulu";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Data Guru</title>
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

        <!-- untuk create -->
        <div class="card ">
            <div class="card-header ">
                Create Data Guru
            </div>
            <div class="card-body">
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

                <form action="" method="POST">
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama</label>
                        <input type="text" name="nama" value="<?php echo $nama ?>" id="nama" class="form-control"
                            placeholder="Contoh: Muhammad Syarifudin Hidayat" autofocus required>
                    </div>
                    <div class="mb-3">
                        <label for="nip" class="form-label">NIP</label>
                        <input type="text" name="nip" id="nip" value="<?php echo $nip ?>" class="form-control"
                            placeholder="Contoh: 23080960032" autofocus required>
                    </div>
                    <div class="mb-3">
                        <label for="pelajaran" class="form-label">Mata Pelajaran</label>
                        <select id="pelajaran" name="pelajaran" class="form-select">
                            <option value="">--pilih mata pelajaran--</option>
                            <option value="Matematika" <?php if ($pelajaran == 'Matematika')
                                echo 'selected'; ?>>
                                Matematika</option>
                            <option value="IPA" <?php if ($pelajaran == 'IPA')
                                echo 'selected'; ?>>IPA</option>
                            <option value="IPS" <?php if ($pelajaran == 'IPS')
                                echo 'selected'; ?>>IPS</option>
                        </select>
                    </div>
                    <button type="submit" name="submit" value="simpan data" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
</body>

</html>