<?php
  session_start();
  require 'koneksi.php';
  require 'fungsi.php';

  $sql = "SELECT * FROM tbl_biodata ORDER BY eid DESC";
  $q = mysqli_query($conn, $sql);
  if (!$q) {
    die("Query error: " . mysqli_error($conn));
  }
?>

<?php
  $flash_sukses_biodata = $_SESSION['flash_sukses_biodata'] ?? ''; #jika query sukses
  $flash_error_biodata  = $_SESSION['flash_error_biodata'] ?? ''; #jika ada error
  #bersihkan session ini
  unset($_SESSION['flash_sukses_biodata'], $_SESSION['flash_error_biodata']); 
?>

<?php if (!empty($flash_sukses_biodata)): ?>
        <div style="padding:10px; margin-bottom:10px; 
          background:#d4edda; color:#155724; border-radius:6px;">
          <?= $flash_sukses_biodata; ?>
        </div>
<?php endif; ?>

<?php if (!empty($flash_error_biodata)): ?>
        <div style="padding:10px; margin-bottom:10px; 
          background:#f8d7da; color:#721c24; border-radius:6px;">
          <?= $flash_error_biodata; ?>
        </div>
<?php endif; ?>

<table border="1" cellpadding="8" cellspacing="0">
  <tr>
    <th>No</th>
    <th>Aksi</th>
    <th>ID</th>
    <th>Nim</th>
    <th>Nama lengkap</th>
    <th>Tempat Lahir</th>
    <th>Tanggal Lahir</th>
    <th>Hobi</th>
    <th>Pasangan</th>
    <th>Pekerjaan</th>
    <th>Nama Orang tua</th>
    <th>Nama Kakak</th>
    <th>Nama Adik</th>
    <th>Created At</th>
  </tr>
  <?php $i = 1; ?>
  <?php while ($row = mysqli_fetch_assoc($q)): ?>
    <tr>
      <td><?= $i++ ?></td>
      <td>
        <a href="bioedit.php?eid=<?= (int)$row['eid']; ?>">Edit</a>
        <a onclick="return confirm('Hapus <?= htmlspecialchars($row['enim']); ?>?')" href="biodelete.php?eid=<?= (int)$row['eid']; ?>">Delete</a>
      </td>
      <td><?= $row['eid']; ?></td>
      <td><?= htmlspecialchars($row['enim']); ?></td>
      <td><?= htmlspecialchars($row['enamalengkap']); ?></td>
      <td><?= htmlspecialchars($row['etempatlahir']); ?></td>
      <td><?= htmlspecialchars($row['etanggallahir']); ?></td>
      <td><?= htmlspecialchars($row['ehobi']); ?></td>
      <td><?= htmlspecialchars($row['epasangan']); ?></td>
      <td><?= htmlspecialchars($row['epekerjaan']); ?></td>
      <td><?= htmlspecialchars($row['enamaorangtua']); ?></td>
      <td><?= htmlspecialchars($row['enamakakak']); ?></td>
      <td><?= htmlspecialchars($row['enamaadik']); ?></td>
      <td><?= formatTanggal(htmlspecialchars($row['ecreatedat'])); ?></td>
    </tr>
  <?php endwhile; ?>
</table>