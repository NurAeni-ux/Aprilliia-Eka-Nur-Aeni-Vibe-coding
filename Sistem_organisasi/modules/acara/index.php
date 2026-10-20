<?php
require_once "../../includes/header.php";

if (isset($_GET['hapus']) && ($_SESSION['role'] == 'Ketua' || $_SESSION['role'] == 'Sekretaris')) {
    $id = intval($_GET['hapus']);
    mysqli_query($conn, "DELETE FROM acara WHERE id = $id");
    echo "<script>window.location.href='index.php';</script>";
}
?>

<div class="card-table">
  <div class="table-header">
    <h3>Data Kegiatan / Acara</h3>
    <?php if ($_SESSION['role'] == 'Ketua' || $_SESSION['role'] == 'Sekretaris'): ?>
      <a href="tambah.php" class="btn btn-primary">+ Tambah Acara</a>
    <?php endif; ?>
  </div>

  <table>
    <thead>
      <tr>
        <th>No</th>
        <th>Nama Acara</th>
        <th>Tanggal</th>
        <th>Lokasi</th>
        <th>Status</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $no = 1;
      $query = mysqli_query($conn, "SELECT * FROM acara ORDER BY tanggal_mulai DESC");
      while ($d = mysqli_fetch_assoc($query)):
      ?>
      <tr>
        <td><?= $no++; ?></td>
        <td><strong><?= htmlspecialchars($d['nama_acara']); ?></strong></td>
        <td><?= $d['tanggal_mulai']; ?> s/d <?= $d['tanggal_selesai']; ?></td>
        <td><?= htmlspecialchars($d['lokasi']); ?></td>
        <td><span class="badge badge-warning"><?= $d['status']; ?></span></td>
        <td>
          <?php if ($_SESSION['role'] == 'Ketua' || $_SESSION['role'] == 'Sekretaris'): ?>
            <a href="index.php?hapus=<?= $d['id']; ?>" class="btn btn-danger" onclick="return confirm('Hapus acara ini?')">Hapus</a>
          <?php else: ?>
            <span style="font-size: 12px; color: #888;">Hanya Lihat</span>
          <?php endif; ?>
        </td>
      </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>

<?php require_once "../../includes/footer.php"; ?>