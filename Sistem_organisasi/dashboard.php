<?php
require_once "includes/header.php";

// Perhitungan Ringkasan Stat
$count_anggota = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM users"))['total'];
$count_acara   = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM acara"))['total'];
$count_tugas   = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM tugas WHERE status != 'Selesai'"))['total'];

// Kalkulasi Keuangan Otomatis
$pemasukan   = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(jumlah) as total FROM keuangan WHERE jenis='Pemasukan'"))['total'] ?? 0;
$pengeluaran = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(jumlah) as total FROM keuangan WHERE jenis='Pengeluaran'"))['total'] ?? 0;
$sisa_anggaran = $pemasukan - $pengeluaran;
?>

<h2 style="margin-bottom: 20px; color: var(--hijau-tua);">Dashboard Ringkasan</h2>

<div class="grid-cards">
  <div class="card-stat">
    <h4>TOTAL ANGGOTA PANITIA</h4>
    <div class="value"><?= $count_anggota; ?> orang</div>
  </div>
  <div class="card-stat">
    <h4>KEGIATAN / ACARA</h4>
    <div class="value"><?= $count_acara; ?> Acara</div>
  </div>
  <div class="card-stat">
    <h4>TUGAS BELUM SELESAI</h4>
    <div class="value"><?= $count_tugas; ?> Tugas</div>
  </div>
  <div class="card-stat" style="border-left-color: var(--hijau-muda);">
    <h4>SISA ANGGARAN OTOMATIS</h4>
    <div class="value" style="font-size: 18px;">Rp <?= number_format($sisa_anggaran, 0, ',', '.'); ?></div>
  </div>
</div>

<div class="card-table">
  <div class="table-header">
    <h3>Progres Tugas Kepanitiaan Terkini</h3>
  </div>
  <table>
    <thead>
      <tr>
        <th>Acara</th>
        <th>Divisi</th>
        <th>Nama Tugas</th>
        <th>Tenggat (Deadline)</th>
        <th>Status</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $query_tugas = mysqli_query($conn, "SELECT t.*, a.nama_acara, d.nama_divisi 
                                         FROM tugas t 
                                         JOIN acara a ON t.acara_id = a.id 
                                         JOIN divisi d ON t.divisi_id = d.id 
                                         ORDER BY t.deadline ASC LIMIT 5");
      while ($t = mysqli_fetch_assoc($query_tugas)):
      ?>
      <tr>
        <td><?= htmlspecialchars($t['nama_acara']); ?></td>
        <td><?= htmlspecialchars($t['nama_divisi']); ?></td>
        <td><?= htmlspecialchars($t['nama_tugas']); ?></td>
        <td><?= $t['deadline']; ?></td>
        <td>
          <?php if($t['status'] == 'Selesai'): ?>
            <span class="badge badge-success">Selesai</span>
          <?php elseif($t['status'] == 'Proses'): ?>
            <span class="badge badge-warning">Proses</span>
          <?php else: ?>
            <span class="badge badge-danger">Belum</span>
          <?php endif; ?>
        </td>
      </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>

<?php require_once "includes/footer.php"; ?>