<?php
require_once "../../includes/header.php";
check_role(['Ketua', 'Sekretaris']);

if (isset($_POST['simpan'])) {
    $nama    = mysqli_real_escape_string($conn, $_POST['nama_acara']);
    $mulai   = $_POST['tanggal_mulai'];
    $selesai = $_POST['tanggal_selesai'];
    $lokasi  = mysqli_real_escape_string($conn, $_POST['lokasi']);
    $desc    = mysqli_real_escape_string($conn, $_POST['deskripsi']);

    mysqli_query($conn, "INSERT INTO acara (nama_acara, tanggal_mulai, tanggal_selesai, lokasi, deskripsi) 
                         VALUES ('$nama', '$mulai', '$selesai', '$lokasi', '$desc')");
    header("Location: index.php");
    exit();
}
?>

<div class="card-table" style="max-width: 600px;">
  <h3>Tambah Acara Baru</h3>
  <form method="POST" action="">
    <div class="form-group">
      <label>Nama Acara</label>
      <input type="text" name="nama_acara" class="form-control" required>
    </div>
    <div class="form-group">
      <label>Tanggal Mulai</label>
      <input type="date" name="tanggal_mulai" class="form-control" required>
    </div>
    <div class="form-group">
      <label>Tanggal Selesai</label>
      <input type="date" name="tanggal_selesai" class="form-control" required>
    </div>
    <div class="form-group">
      <label>Lokasi</label>
      <input type="text" name="lokasi" class="form-control" required>
    </div>
    <div class="form-group">
      <label>Deskripsi</label>
      <textarea name="deskripsi" class="form-control" rows="3"></textarea>
    </div>
    <button type="submit" name="simpan" class="btn btn-primary">Simpan Acara</button>
    <a href="index.php" class="btn" style="background:#ccc;">Batal</a>
  </form>
</div>

<?php require_once "../../includes/footer.php"; ?>