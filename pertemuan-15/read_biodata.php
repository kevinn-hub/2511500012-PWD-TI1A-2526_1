<?php
  session_start();
  require 'koneksi.php';
  require 'fungsi.php';

  $sql = "SELECT * FROM tbl_mahasiswa ORDER BY eid DESC";
  $q = mysqli_query($conn, $sql);
  if (!$q) {
    die("Query error: " . mysqli_error($conn));
  }
?>

<?php
  $flash_sukses = $_SESSION['flash_sukses'] ?? ''; #jika query sukses
  $flash_error  = $_SESSION['flash_error'] ?? ''; #jika ada error
  #bersihkan session ini
  unset($_SESSION['flash_sukses'], $_SESSION['flash_error']); 
?>

<?php if (!empty($flash_sukses)): ?>
        <div style="padding:10px; margin-bottom:10px; 
          background:#d4edda; color:#155724; border-radius:6px;">
          <?= $flash_sukses; ?>
        </div>
<?php endif; ?>

<?php if (!empty($flash_error)): ?>
        <div style="padding:10px; margin-bottom:10px; 
          background:#f8d7da; color:#721c24; border-radius:6px;">
          <?= $flash_error; ?>
        </div>
<?php endif; ?>

<table border="1" cellpadding="8" cellspacing="0">
    <tr>
      <th>No</th>
      <th>Aksi</th>
      <th>ID</th>
      <th>Nim</th>
      <th>Nama Lengkap</th>
      <th>Tanggal lahir</th>
      <th>Tempat Lahir</th>
      <th>hobi</th>
      <th>pasangan</th>
      <th>Nama Orang Tua</th>
      <th>Nama kakak</th>
      <th>Nama adik</th>
      <th>Created At</th>
    </tr>
  <?php $i = 1; ?>
  <?php while ($row = mysqli_fetch_assoc($q)): ?>
    <tr>
      <td><?= $i++ ?></td>
      <td>
        <a href="edit.php?cid=<?= (int)$row['cid']; ?>">Edit</a>
        <a onclick= "return confirm('Hapus <?= htmlspecialchars($row['cnama']); ?>?')" href="proses_delete.php?cid=<?= (int)$row['cid']; ?>">Delete</a>
      </td>
      <td><?= $row['eid']; ?></td>
      <td><?= htmlspecialchars($row['enim']); ?></td>
      <td><?= htmlspecialchars($row['enamalengkap']); ?></td>
      <td><?= htmlspecialchars($row['etempatllahir']); ?></td>
      <td><?= htmlspecialchars($row['etanggallahir']); ?></td>
      <td><?= htmlspecialchars($row['ehobi']); ?></td>
      <td><?= htmlspecialchars($row['epasangan']); ?></td>
      <td><?= htmlspecialchars($row['epekerjaan']); ?></td>
      <td><?= htmlspecialchars($row['enamortu']); ?></td>
      <td><?= htmlspecialchars($row['enamakakak']); ?></td>
      <td><?= htmlspecialchars($row['enamadik']); ?></td>
      <td><?= formatTanggal(htmlspecialchars($row['dcreated_at'])); ?></td>
    </tr>
  <?php endwhile; ?>
</table>

<?php
if (!$q) {
  die("Query eror: " . mysqli_error($conn));
}
?>