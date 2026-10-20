<?php
require_once "../../includes/header.php";

if (isset($_GET['hapus']) && ($_SESSION['role'] == 'Ketua' || $_SESSION['role'] == 'Sekretaris')) {
    $id = intval($_GET['hapus']);
    mysqli_query($conn, "DELETE FROM users WHERE id = $id");
    echo "<script>window.location.href='index.php';</script>";
}
?>

<div class="card-table">
  <div class="table-header">
    <h3>Data Anggota & Akun Panitia</h3>
    <?php if ($_SESSION['role'] == 'Ketua' || $_SESSION['role'] == 'Sekretaris'): ?>
      <a href="tambah.php" class="btn btn-primary">+ Tambah Anggota</a>
    <?php endif; ?>
  </div>

  <table>
    <thead>
      <tr>
        <th>Nama</th>
        <th>Username</th>
        <th>Role / Jabatan</th>
        <th>Divisi</th>
        <th>No HP</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $query = mysqli_query($conn, "SELECT u.*, d.nama_divisi FROM users u LEFT JOIN divisi d ON u.divisi_id = d.id ORDER BY u.id ASC");
      while ($u = mysqli_fetch_assoc($query)):
      ?>
      <tr>
        <td><strong><?= htmlspecialchars($u['nama']); ?></strong></td>
        <td><?= htmlspecialchars($u['username']); ?></td>
        <td><span class="role-badge"><?= $u['role']; ?></span></td>
        <td><?= htmlspecialchars($u['nama_divisi'] ?? '-'); ?></td>
        <td><?= htmlspecialchars($u['no_hp']); ?></td>
        <td>
          <?php if (($_SESSION['role'] == 'Ketua' || $_SESSION['role'] == 'Sekretaris') && $u['id'] != $_SESSION['user_id']): ?>
            <a href="index.php?hapus=<?= $u['id']; ?>" class="btn btn-danger" onclick="return confirm('Hapus user ini?')">Hapus</a>
          <?php endif; ?>
        </td>
      </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>

<?php require_once "../../includes/footer.php"; ?>