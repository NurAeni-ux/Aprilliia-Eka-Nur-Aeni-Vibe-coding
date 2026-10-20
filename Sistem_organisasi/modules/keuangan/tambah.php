<?php
require_once "../../includes/header.php";
check_role(['Ketua', 'Bendahara']);

if (isset($_POST['simpan'])) {
    $acara_id   = intval($_POST['acara_id']);
    $jenis      = $_POST['jenis'];
    $kategori   = mysqli_real_escape_string($conn, $_POST['kategori']);
    $jumlah     = intval($_POST['jumlah']);
    $keterangan = mysqli_real_escape_string($conn, $_POST['keterangan']);
    $tanggal    = $_POST['tanggal'];
    $user_id    = $_SESSION['user_id'];

    mysqli_query($conn, "INSERT INTO keuangan (acara_id, jenis, kategori, jumlah, keterangan, tanggal, created_by) 
                         VALUES ($acara_id, '$jenis', '$kategori', $jumlah, '$keterangan', '$tanggal', $user_id)");
    header("Location: index.php");
    exit();
}
?>

<div class="card-table" style="max-width: 600px;">
  <h3>Catat Transaksi Keuangan</h3>
  <form method="POST" action="">
    <div class="form-group">
      <label>Acara</label>
      <select name="acara_id" class="form-control" required>
        <?php
        $q = mysqli_query($conn, "SELECT * FROM acara");
        while ($a = mysqli_fetch_assoc($q)) echo "<option value='{$a['id']}'>{$a['nama_acara']}</option>";
        ?>
      </select>
    </div>
    <div class="form-group">
      <label>Jenis Transaksi</label>
      <select name="jenis" class="form-control" required>
        <option value="Pemasukan">Pemasukan (Dana Masuk / Sponsor)</option>
        <option value="Pengeluaran">Pengeluaran (Belanja / Sewa / Konsumsi)</option>
      </select>
    </div>
    <div class="form-group">
      <label>Kategori</label>
      <input type="text" name="kategori" class="form-control" placeholder="Contoh: Sponsor, Perlengkapan, Konsumsi" required>
    </div>
    <div class="form-group">
      <label>Jumlah Nominal (Rp)</label>
      <input type="number" name="jumlah" class="form-control" required>
    </div>
    <div class="form-group">
      <label>Tanggal Transaksi</label>
      <input type="date" name="tanggal" class="form-control" value="<?= date('Y-m-d'); ?>" required>
    </div>
    <div class="form-group">
      <label>Keterangan Tambahan</label>
      <textarea name="keterangan" class="form-control" rows="2"></textarea>
    </div>
    <button type="submit" name="simpan" class="btn btn-primary">Simpan Transaksi</button>
  </form>
</div>

<?php require_once "../../includes/footer.php"; ?>