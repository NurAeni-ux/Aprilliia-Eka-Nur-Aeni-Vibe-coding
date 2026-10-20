<?php
require_once "../../includes/header.php";

if (isset($_POST['tambah']) && ($_SESSION['role'] == 'Ketua' || $_SESSION['role'] == 'Sekretaris')) {
    $nama_divisi = mysqli_real_escape_string($conn, $_POST['nama_divisi']);
    $deskripsi   = mysqli_real_escape_string($conn, $_POST['deskripsi']);
    
    mysqli_query($conn, "INSERT INTO divisi (nama_divisi, deskripsi) VALUES ('$nama_divisi', '$deskripsi')");
    echo "<script>window.location.href='index.php';</script>";
}
?>

<div class="card-table">
  <div class="table-header">
    <h3>Data Divisi Kepanitiaan</h3>
  </div>

  <?php if ($_SESSION['role'] == 'Ketua' || $_SESSION['role'] == 'Sekretaris'): ?>
  <form method="POST" action="" style="margin-bottom: 20px; background: var(--cream); padding: 15px; border-radius: 6px;">
    <h4>Form Tambah Divisi</h4>
    <div class="form-group">
      <label>Nama Divisi</label>
      <input type="text" name="nama_divisi" class="form-control" required placeholder="Contoh: Divisi Konsumsi">
    </div>
    <div class="form-group">
      <label>Deskripsi Tugas Divisi</label>
      <input type="text" name="deskripsi" class="form-control" placeholder="Tugas utama divisi...">
    </div>
    <button type="submit" name="tambah" class="btn btn-primary">Simpan Divisi</button>
  </form>
  <?php endif; ?>

  <table>
    <thead>
      <tr>
        <th>ID</th>
        <th>Nama Divisi</th>
        <th>Deskripsi / Tanggung Jawab</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $query = mysqli_query($conn, "SELECT * FROM divisi ORDER BY id ASC");
      while ($row = mysqli_fetch_assoc($query)):
      ?>
      <tr>
        <td><?= $row['id']; ?></td>
        <td><strong><?= htmlspecialchars($row['nama_divisi']); ?></strong></td>
        <td><?= htmlspecialchars($row['deskripsi']); ?></td>
      </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>

<?php require_once "../../includes/footer.php"; ?>