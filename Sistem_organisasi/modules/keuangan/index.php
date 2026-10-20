<?php
require_once "../../includes/header.php";

// Total Keuangan
$pemasukan   = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(jumlah) as total FROM keuangan WHERE jenis='Pemasukan'"))['total'] ?? 0;
$pengeluaran = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(jumlah) as total FROM keuangan WHERE jenis='Pengeluaran'"))['total'] ?? 0;
$sisa        = $pemasukan - $pengeluaran;

if (isset($_GET['hapus']) && ($_SESSION['role'] == 'Ketua' || $_SESSION['role'] == 'Bendahara')) {
    $id = intval($_GET['hapus']);
    mysqli_query($conn, "DELETE FROM keuangan WHERE id = $id");
    echo "<script>window.location.href='index.php';</script>";
}
?>

<div class="grid-cards">
  <div class="card-stat">
    <h4>TOTAL PEMASUKAN</h4>
    <div class="value" style="color: green;">Rp <?= number_format($pemasukan, 0, ',', '.'); ?></div>
  </div>
  <div class="card-stat">
    <h4>TOTAL PENGELUARAN</h4>
    <div class="value" style="color: var(--merah);">Rp <?= number_format($pengeluaran, 0, ',', '.'); ?></div>
  </div>
  <div class="card-stat" style="border-left-color: var(--hijau-sedang);">
    <h4>SISA ANGGARAN OTOMATIS</h4>
    <div class="value">Rp <?= number_format($sisa, 0, ',', '.'); ?></div>
  </div>
</div>

<div class="card-table">
  <div class="table-header">
    <h3>Pencatatan Keuangan Panitia</h3>
    <?php if ($_SESSION['role'] == 'Ketua' || $_SESSION['role'] == 'Bendahara'): ?>
      <a href="tambah.php" class="btn btn-primary">+ Catat Transaksi</a>
    <?php endif; ?>
  </div>

  <table>
    <thead>
      <tr>
        <th>Tanggal</th>
        <th>Acara</th>
        <th>Jenis</th>
        <th>Kategori</th>
        <th>Keterangan</th>
        <th>Jumlah (Rp)</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $query = mysqli_query($conn, "SELECT k.*, a.nama_acara FROM keuangan k JOIN acara a ON k.acara_id = a.id ORDER BY k.tanggal DESC");
      while ($k = mysqli_fetch_assoc($query)):
      ?>
      <tr>
        <td><?= $k['tanggal']; ?></td>
        <td><?= htmlspecialchars($k['nama_acara']); ?></td>
        <td>
          <span class="badge <?= $k['jenis'] == 'Pemasukan' ? 'badge-success' : 'badge-danger'; ?>">
            <?= $k['jenis']; ?>
          </span>
        </td>
        <td><?= htmlspecialchars($k['kategori']); ?></td>
        <td><?= htmlspecialchars($k['keterangan']); ?></td>
        <td><strong>Rp <?= number_format($k['jumlah'], 0, ',', '.'); ?></strong></td>
        <td>
          <?php if ($_SESSION['role'] == 'Ketua' || $_SESSION['role'] == 'Bendahara'): ?>
            <a href="index.php?hapus=<?= $k['id']; ?>" class="btn btn-danger" onclick="return confirm('Hapus transaksi ini?')">Hapus</a>
          <?php endif; ?>
        </td>
      </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>

<?php require_once "../../includes/footer.php"; ?>