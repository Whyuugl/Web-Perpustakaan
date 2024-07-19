<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Perpustakaan UMUM</title>
</head>

<?php
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Konfigurasi database
    $host = 'localhost';  // Ganti dengan host database Anda
    $username = 'root';   // Ganti dengan username database Anda
    $password = '';       // Ganti dengan password database Anda
    $dbname = 'db_perpus'; // Ganti dengan nama database Anda

    // Membuat koneksi ke database
    $conn = new mysqli($host, $username, $password, $dbname);

    // Memeriksa koneksi
    if ($conn->connect_error) {
        die("Koneksi gagal: " . $conn->connect_error);
    }

    // Query untuk mengambil data peminjaman berdasarkan id
    $sql = "SELECT * FROM peminjaman WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Memeriksa apakah ada hasil
    if ($result->num_rows > 0) {
        // Mendapatkan data peminjaman
        $row = $result->fetch_assoc();

        // Menutup statement
        $stmt->close();
    } else {
        echo "<script>alert('Data peminjaman tidak ditemukan.'); window.location.href = 'peminjaman.php';</script>";
    }

    // Menutup koneksi
    $conn->close();
} else {
    echo "<script>alert('Parameter id tidak ditemukan.'); window.location.href = 'peminjaman.php';</script>";
}
?>

<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <img class="navbar-brand" src="plugins/img/th.jpeg" style="width: 80px;">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="index.php">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="buku.php">Buku</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="anggota.php">Anggota</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Transaksi
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="peminjaman.php">Peminjaman</a></li>
                            <li><a class="dropdown-item" href="#">Pengembalian</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="py-5 text-center">
            <img class="navbar-brand" src="plugins/img/th.jpeg" style="width: 80px;">
            <h2>Form Edit Peminjaman</h2>
            <p class="lead">Silakan edit form di bawah ini untuk mengubah data peminjaman.</p>
        </div>
        <div class="col-md-7 col-lg-8">
            <form class="needs-validation" novalidate action="../proses/proses_edit_pinjam.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                <input type="hidden" name="existing_foto_buku" value="<?php echo $row['foto_buku']; ?>">
                <div class="row g-3">
                    <div class="col-12">
                        <label for="nama_peminjam" class="form-label">Nama Peminjam</label>
                        <input type="text" class="form-control" id="nama_peminjam" name="nama_peminjam" value="<?php echo $row['nama_peminjam']; ?>" required>
                    </div>
                    <div class="col-12">
                        <label for="nama_buku" class="form-label">Nama Buku</label>
                        <input type="text" class="form-control" id="nama_buku" name="nama_buku" value="<?php echo $row['nama_buku']; ?>" required>
                    </div>
                    <div class="col-12">
                        <label for="tanggal_peminjaman" class="form-label">Tanggal Peminjaman</label>
                        <input type="date" class="form-control" id="tanggal_peminjaman" name="tanggal_peminjaman" value="<?php echo $row['tanggal_peminjaman']; ?>" required>
                    </div>
                    <div class="col-12">
                        <label for="foto_buku" class="form-label">Foto Buku</label>
                        <div class="mb-3">
                            <img src="../uploads/<?php echo $row['foto_buku']; ?>" class="img-thumbnail" alt="Foto Buku">
                        </div>
                        <input type="file" class="form-control" id="foto_buku" name="foto_buku">
                        <div class="invalid-feedback">
                            Masukkan Foto Buku.
                        </div>
                    </div>
                </div>
                <hr class="my-4">
                <div class="btn-group d-flex justify-content-between align-items-center gap-4">
                    <button class="w-100 btn btn-primary btn-lg" type="submit">Simpan Perubahan</button>
                    <a class="w-100 btn btn-warning btn-lg" href="peminjaman.php">Batal</a>
                </div>
            </form>
        </div>
    </div>

    <footer class="d-flex flex-wrap justify-content-between align-items-center py-3 my-4 border-top">
        <p class="col-md-4 mb-0 text-body-secondary">&copy; 2024 Company, Inc</p>
        <a href="/" class="col-md-4 d-flex align-items-center justify-content-center mb-3 mb-md-0 me-md-auto link-body-emphasis text-decoration-none">
            <svg class="bi me-2" width="40" height="32">
                <use xlink:href="#bootstrap" />
            </svg>
        </a>
        <ul class="nav col-md-4 justify-content-end">
            <li class="nav-item"><a href="#" class="nav-link px-2 text-body-secondary">Home</a></li>
            <li class="nav-item"><a href="#" class="nav-link px-2 text-body-secondary">Features</a></li>
            <li class="nav-item"><a href="#" class="nav-link px-2 text-body-secondary">Pricing</a></li>
            <li class="nav-item"><a href="#" class="nav-link px-2 text-body-secondary">FAQs</a></li>
            <li class="nav-item"><a href="#" class="nav-link px-2 text-body-secondary">About</a></li>
        </ul>
    </footer>

    <!-- Script Boostrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>
