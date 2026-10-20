<?php
require_once "../../includes/header.php";

$pemasukan   = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(jumlah) as total FROM keuangan WHERE jenis='Pemasukan'"))['total'] ?? 0;
$pengeluaran = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(jumlah) as total FROM keuangan WHERE jenis='Pengeluaran'"))['total'] ?? 0;
$sisa        = $pemasukan - $pengeluaran;

$tugas_selesai = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM tugas WHERE status='Selesai'"))['total'];
$total_tugas   = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM tugas"))['total'];
$persen_tugas  = $total_tugas > 0 ? round(($tugas_selesai / $total_tugas) * 100) : 0;
?>

<div class="card-table">
  <div class="table-header">
    <h3>Laporan Pertanggungjawaban (LPJ) Kepanitiaan</h3>
    <button onclick="window.print()" class="btn btn-primary">Cetak Laporan (Print)</button>
  </div>

  <div style="background-color: var(--cream); padding: 20px; border-radius: 6px; margin-bottom: 20px;">
    <h4 style="color: var(--hijau-tua); margin-bottom: 10px;">Ringkasan Progres & Keuangan</h4>
    <p><strong>Progres Tugas Panitia:</strong> <?= $tugas_selesai; ?> dari <?= $total_tugas; ?> Tugas Selesai (<?= $persen_tugas; ?>%)</p>
    <p><strong>Total Pemasukan:</strong> Rp <?= number_format($pemasukan, 0, ',', '.'); ?></p>
    <p><strong>Total Pengeluaran:</strong> Rp <?= number_format($pengeluaran, 0, ',', '.'); ?></p>
    <p><strong>Sisa Anggaran:</strong> Rp <?= number_format($sisa, 0, ',', '.'); ?></p>
  </div>

  <h4>Rincian Pengeluaran</h4>
  <table style="margin-top: 10px; margin-bottom: 25px;">
    <thead>
      <tr>
        <th>Tanggal</th>
        <th>Kategori</th>
        <th>Keterangan</th>
        <th>Jumlah</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $q = mysqli_query($conn, "SELECT * FROM keuangan WHERE jenis='Pengeluaran' ORDER BY tanggal ASC");
      while ($r = mysqli_fetch_assoc($q)):
      ?>
      <tr>
        <td><?= $r['tanggal']; ?></td>
        <td><?= htmlspecialchars($r['kategori']); ?></td>
        <td><?= htmlspecialchars($r['keterangan']); ?></td>
        <td>Rp <?= number_format($r['jumlah'], 0, ',', '.'); ?></td>
      </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>

<?php require_once "../../includes/footer.php"; ?>