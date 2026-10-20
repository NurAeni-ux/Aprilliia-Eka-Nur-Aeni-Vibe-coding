<?php
require_once "../../includes/header.php";
check_role(['Ketua', 'Sekretaris']);

if (isset($_POST['simpan'])) {
    $nama      = mysqli_real_escape_string($conn, $_POST['nama']);
    $username  = mysqli_real_escape_string($conn, $_POST['username']);
    $password  = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role      = $_POST['role'];
    $divisi_id = intval($_POST['divisi_id']);
    $email     = mysqli_real_escape_string($conn, $_POST['email']);
    $no_hp     = mysqli_real_escape_string($conn, $_POST['no_hp']);

    mysqli_query($conn, "INSERT INTO users (nama, username, password, role, divisi_id, email, no_hp) 
                         VALUES ('$nama', '$username', '$password', '$role', '$divisi_id', '$email', '$no_hp')");
    header("Location: index.php");
    exit();
}
?>

<div class="card-table" style="max-width: 600px;">
  <h3>Tambah Anggota Panitia</h3>
  <form method="POST" action="">
    <div class="form-group">
      <label>Nama Lengkap</label>
      <input type="text" name="nama" class="form-control" required>
    </div>
    <div class="form-group">
      <label>Username</label>
      <input type="text" name="username" class="form-control" required>
    </div>
    <div class="form-group">
      <label>Password</label>
      <input type="password" name="password" class="form-control" required>
    </div>
    <div class="form-group">
      <label>Role Hak Akses</label>
      <select name="role" class="form-control" required>
        <option value="Anggota">Anggota</option>
        <option value="Koordinator">Koordinator</option>
        <option value="Bendahara">Bendahara</option>
        <option value="Sekretaris">Sekretaris</option>
        <option value="Ketua">Ketua</option>
      </select>
    </div>
    <div class="form-group">
      <label>Divisi</label>
      <select name="divisi_id" class="form-control" required>
        <?php
        $q_div = mysqli_query($conn, "SELECT * FROM divisi");
        while ($d = mysqli_fetch_assoc($q_div)) {
            echo "<option value='{$d['id']}'>{$d['nama_divisi']}</option>";
        }
        ?>
      </select>
    </div>
    <div class="form-group">
      <label>Email</label>
      <input type="email" name="email" class="form-control">
    </div>
    <div class="form-group">
      <label>No HP/WhatsApp</label>
      <input type="text" name="no_hp" class="form-control">
    </div>
    <button type="submit" name="simpan" class="btn btn-primary">Simpan Anggota</button>
  </form>
</div>

<?php require_once "../../includes/footer.php"; ?>