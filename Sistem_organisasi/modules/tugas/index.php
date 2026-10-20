<?php
require_once "../../includes/header.php";

// Update status tugas jika disubmit
if (isset($_POST['update_status'])) {
    $tugas_id = intval($_POST['tugas_id']);
    $status   = $_POST['status'];
    mysqli_query($conn, "UPDATE tugas SET status='$status' WHERE id=$tugas_id");
    echo "<script>window.location.href='index.php';</script>";
}
?>

<div class="card-table">
  <div class="table-header">
    <h3>Daftar & Status Tugas Panitia</h3>
    <?php if (in_array($_SESSION['role'], ['Ketua', 'Sekretaris', 'Koordinator'])): ?>
      <a href="tambah.php" class="btn btn-primary">+ Bagi Tugas Baru</a>
    <?php endif; ?>
  </div>

  <table>
    <thead>
      <tr>
        <th>Tugas</th>
        <th>Acara & Divisi</th>
        <th>Penanggung Jawab</th>
        <th>Deadline</th>
        <th>Prioritas</th>
        <th>Status</th>
        <th>Pembaruan Status</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $query = mysqli_query($conn, "SELECT t.*, a.nama_acara, d.nama_divisi, u.nama as nama_pj 
                                   FROM tugas t 
                                   JOIN acara a ON t.acara_id = a.id 
                                   JOIN divisi d ON t.divisi_id = d.id 
                                   LEFT JOIN users u ON t.assigned_to = u.id 
                                   ORDER BY t.deadline ASC");
      while ($t = mysqli_fetch_assoc($query)):
      ?>
      <tr>
        <td>
          <strong><?= htmlspecialchars($t['nama_tugas']); ?></strong><br>
          <small><?= htmlspecialchars($t['deskripsi']); ?></small>
        </td>
        <td><?= htmlspecialchars($t['nama_acara']); ?><br><small>(<?= htmlspecialchars($t['nama_divisi']); ?>)</small></td>
        <td><?= htmlspecialchars($t['nama_pj'] ?? 'Semua Divisi'); ?></td>
        <td><?= $t['deadline']; ?></td>
        <td><span class="badge badge-warning"><?= $t['prioritas']; ?></span></td>
        <td>
          <?php if($t['status'] == 'Selesai'): ?>
            <span class="badge badge-success">Selesai</span>
          <?php elseif($t['status'] == 'Proses'): ?>
            <span class="badge badge-warning">Proses</span>
          <?php else: ?>
            <span class="badge badge-danger">Belum</span>
          <?php endif; ?>
        </td>
        <td>
          <form method="POST" action="" style="display:flex; gap:5px;">
            <input type="hidden" name="tugas_id" value="<?= $t['id']; ?>">
            <select name="status" class="form-control" style="padding:2px 5px; font-size:12px;">
              <option value="Belum" <?= $t['status']=='Belum'?'selected':''; ?>>Belum</option>
              <option value="Proses" <?= $t['status']=='Proses'?'selected':''; ?>>Proses</option>
              <option value="Selesai" <?= $t['status']=='Selesai'?'selected':''; ?>>Selesai</option>
            </select>
            <button type="submit" name="update_status" class="btn btn-primary" style="padding:2px 8px; font-size:12px;">Update</button>
          </form>
        </td>
      </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>

<?php require_once "../../includes/footer.php"; ?>