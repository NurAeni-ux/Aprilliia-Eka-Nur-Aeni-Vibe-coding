<?php
require_once "../../includes/header.php";
check_role(['Ketua', 'Sekretaris', 'Koordinator']);

if (isset($_POST['simpan'])) {
    $acara_id    = intval($_POST['acara_id']);
    $divisi_id   = intval($_POST['divisi_id']);
    $assigned_to = !empty($_POST['assigned_to']) ? intval($_POST['assigned_to']) : "NULL";
    $nama_tugas  = mysqli_real_escape_string($conn, $_POST['nama_tugas']);
    $deskripsi   = mysqli_real_escape_string($conn, $_POST['deskripsi']);
    $deadline    = $_POST['deadline'];
    $prioritas   = $_POST['prioritas'];

    mysqli_query($conn, "INSERT INTO tugas (acara_id, divisi_id, assigned_to, nama_tugas, deskripsi, deadline, prioritas) 
                         VALUES ($acara_id, $divisi_id, $assigned_to, '$nama_tugas', '$deskripsi', '$deadline', '$prioritas')");
    header("Location: index.php");
    exit();
}
?>

<div class="card-table" style="max-width: 600px;">
  <h3>Pembagian Tugas Baru</h3>
  <form method="POST" action="">
    <div class="form-group">
      <label>Pilih Acara</label>
      <select name="acara_id" class="form-control" required>
        <?php
        $q = mysqli_query($conn, "SELECT * FROM acara");
        while ($a = mysqli_fetch_assoc($q)) echo "<option value='{$a['id']}'>{$a['nama_acara']}</option>";
        ?>
      </select>
    </div>
    <div class="form-group">
      <label>Divisi Penanggung Jawab</label>
      <select name="divisi_id" class="form-control" required>
        <?php
        $q = mysqli_query($conn, "SELECT * FROM divisi");
        while ($d = mysqli_fetch_assoc($q)) echo "<option value='{$d['id']}'>{$d['nama_divisi']}</option>";
        ?>
      </select>
    </div>
    <div class="form-group">
      <label>Petugas Spesifik (Opsional)</label>
      <select name="assigned_to" class="form-control">
        <option value="">-- Semua Anggota Divisi --</option>
        <?php
        $q = mysqli_query($conn, "SELECT * FROM users WHERE role='Anggota' OR role='Koordinator'");
        while ($u = mysqli_fetch_assoc($q)) echo "<option value='{$u['id']}'>{$u['nama']}</option>";
        ?>
      </select>
    </div>
    <div class="form-group">
      <label>Nama Tugas</label>
      <input type="text" name="nama_tugas" class="form-control" required>
    </div>
    <div class="form-group">
      <label>Deskripsi Detail</label>
      <textarea name="deskripsi" class="form-control" rows="3"></textarea>
    </div>
    <div class="form-group">
      <label>Tenggat Waktu (Deadline)</label>
      <input type="date" name="deadline" class="form-control" required>
    </div>
    <div class="form-group">
      <label>Tingkat Prioritas</label>
      <select name="prioritas" class="form-control">
        <option value="Rendah">Rendah</option>
        <option value="Sedang" selected>Sedang</option>
        <option value="Tinggi">Tinggi</option>
      </select>
    </div>
    <button type="submit" name="simpan" class="btn btn-primary">Simpan & Bagikan Tugas</button>
  </form>
</div>

<?php require_once "../../includes/footer.php"; ?>